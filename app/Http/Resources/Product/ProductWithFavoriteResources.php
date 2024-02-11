<?php

namespace App\Http\Resources\Product;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductWithFavoriteResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

      $user = $request->user();
      $product = Product::where('id',$this->product_id)->first();
      return [
        'id'=>$product->id,
        'name'=>$product->name,
        'mobile_number'=>$product->mobile_number,
        'government'=>$this->government_id? $this->government->name() :'not found',
        'state'=>$this->state_id? $this->state->name() :'not found',
        'whatsApp_number'=>$product->whatsApp_number ? :null,
        'category'=>$product->category_id? $product->category->name() :'not found',
        'subcategory'=>$product->subcategory_id? $product->subCategory->name() :'not found' ,
        'images'=> $product->files->pluck('path')->map(function ($path) {
            return url('public/'.$path);
        })->toArray(),
        'description'=>$product->description ? :null,
        'price'=>$product->selling_price ? :"0",
        'payment way'=>$product->payment_method ? :0,
        'views'=>$product->views ,
        'Sell or rent'=>$product->sell_or_rent ,
        'sale or not'=>$product->salled_or_not  ,
        'Negotiable'=> $product->Negotiable ,
        'contact by phone'=>$product->Contact_by_phone  ,
        'contact by whatspp'=>$product->Contact_by_whatsapp ,
        'user_id' => $product->user_id ,
        'user name'=>$product->user_id  ? $product->user->name :'not found',
        'cearted_at' => $product->updated_at,
        'is_favorite' =>  $user ? $product->favoritedBy->contains($user) : false,
        'favorite_count'=>$product->favoritedBy->count(),
        ];
   
    
     
    }
}
