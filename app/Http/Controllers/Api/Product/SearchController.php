<?php

namespace App\Http\Controllers\Api\Product;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SearchRequest;
use App\Http\Resources\Product\ProductCollection;

class SearchController extends Controller
{
    public function search(SearchRequest $request)
    {
        try {
            $query = Product::query(); // Use query() instead of all()
    
            if ($request->keyword !== '') {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->keyword . '%');
                });
            }
            $perPage = $request->input('perPage', 10);
          
            $products = $query->orderBy('updated_at', 'desc')->paginate($perPage);
            $data = count($products) ? ProductCollection::collection($products) : [];
            return response()->json([
                'success' => true,
                'data' => $data,
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                    ],
                'message' => __('message.success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function searchInCategory(Request $request)
    {
        try {
            $query = Product::where('category_id',$request->category_id); 
    
            if ($request->keyword !== '') {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->keyword . '%');
                });
            }
            $perPage = $request->input('perPage', 10);
          
            $products = $query->orderBy('updated_at', 'desc')->paginate($perPage);
            $data = count($products) ? ProductCollection::collection($products) : [];
            return response()->json([
                'success' => true,
                'data' => $data,
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                    ],
                'message' => __('message.success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    public function searchInMostViews(SearchRequest $request)
    {
        try {
            $query = Product::query(); // Use query() instead of all()
    
            if ($request->keyword !== '') {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->keyword . '%');
                });
            }
            $perPage = $request->input('perPage', 10);
          
            $products = $query->orderBy('views', 'desc')->paginate($perPage);
            $data = count($products) ? ProductCollection::collection($products) : [];
            return response()->json([
                'success' => true,
                'data' => $data,
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'per_page' => $products->perPage(),
                        'total' => $products->total(),
                    ],
                'message' => __('message.success'),
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    
    public function filter(Request $request)
    {
    try {
        $query = Product::query();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }

        if ($request->filled(['minPrice','maxPrice'])) {
            $minPrice = $request->minPrice;
            $maxPrice = $request->maxPrice;
            $query->whereRaw("CAST(SUBSTRING_INDEX(selling_price, ' ', 1) AS DECIMAL) BETWEEN ? AND ?", [$minPrice, $maxPrice]);
        }
        if ($request->filled('government_id')) {
            $query->where('government_id', $request->government_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('sell_or_rent')) {
            $query->where('sell_or_rent', $request->sell_or_rent);
        }

        $perPage = $request->input('perPage', 10);
        $products = $query->orderBy('updated_at', 'desc')->paginate($perPage);
        $data = count($products) ? ProductCollection::collection($products) : [];

        return response()->json([
            'success' => true,
            'data' => $data,
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ],
            'message' => __('message.success'),
        ], 200);
        } catch (\Exception $e) {
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
    }
    

    
}

    

