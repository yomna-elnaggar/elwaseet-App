<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductWithFavoriteResources;

class FavouriteProductController extends Controller
{
    public function addToFavorites(Request $request,$productId)
    {
        $user = $request->user();
    
        // Check if the product is not already in the favorites
        if (!$user->favorites()->where('product_id', $productId)->exists()) {
             $user->favorites()->attach($productId, ['user_id' => $user->id]);
    
            return response()->json(['success' => true, 'message' => 'Product added to favorites']);
        }
    
        return response()->json(['success' => false, 'message' => 'Product is already in favorites']);
    }
    
    public function removeFromFavorites(Request $request,$productId)
    {
        $user = $request->user();
        $user->favorites()->detach($productId);

        return response()->json(['success' => true, 'message' => 'Product removed from favorites']);
    }
    
    public function getFavoriteProducts(Request $request)
    {
        $user = $request->user();
        
        //$favoriteProductsQuery =Favorite::where('user_id',$user->id)->with('product')->gety();
        $favoriteProductsQuery = $user->favorites()->getQuery();
       
        $perPage = $request->input('perPage', 10);
        $favoriteProducts = $favoriteProductsQuery->paginate($perPage);
       // dd($favoriteProducts);
        $data = ProductWithFavoriteResources::collection($favoriteProducts);
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'pagination' => [
                'current_page' => $favoriteProducts->currentPage(),
                'last_page' => $favoriteProducts->lastPage(),
                'per_page' => $favoriteProducts->perPage(),
                'total' => $favoriteProducts->total(),
            ],
            'message' => __('message.success'),
        ], 200);
    }
///get category product that not bloced and show is it favorite
    
    public function is_favorite(Request $request, $id)
    {
        $user_id = $request->user()->id;
        $perPage = $request->input('perPage', 10);
        $product = Product::notBlockedByUser($user_id)->where('category_id',$id)->orderBy('views', 'desc')->paginate($perPage);
        
        $data = ProductCollection::collection($product);
        return response()->json([
            'success' => true,
            'data' => $data,
                'pagination' => [
                    'current_page' => $data->currentPage(),
                    'last_page' => $data->lastPage(),
                    'per_page' => $data->perPage(),
                    'total' => $data->total(),
                ],
            'message' => __('message.success'),
            ], 200);
    }
}
