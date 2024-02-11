<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {     $user = $request->user();
            return [
            'id'=>$this->id,
            'name'=>$this->name,
            'mobile_number'=>$this->mobile_number,
            'government'=>$this->government_id? $this->government->name() :'not found',
            'state'=>$this->state_id? $this->state->name() :'not found',
            'state_id'=>$this->state_id? $this->state->id :'not found',
            'whatsApp_number'=>$this->whatsApp_number ? :null,
            'category'=>$this->category_id? $this->category->name() :'not found',
            'subcategory'=>$this->subcategory_id? $this->subCategory->name() :'not found' ,
            'images'=> $this->files->pluck('path')->map(function ($path) {
                return url('public/'.$path);
            })->toArray(),
            'description'=>$this->description ? :null,
            'price'=>$this->selling_price ? :"0",
            'payment way'=>$this->payment_method ? :0,
            'views'=>$this->views ,
            'Sell or rent'=>$this->sell_or_rent ,
            'sale or not'=>$this->salled_or_not? :0  ,
            'Negotiable'=> $this->Negotiable ,
            'contact by phone'=>$this->Contact_by_phone  ,
            'contact by whatspp'=>$this->Contact_by_whatsapp ,
            'cearted_at' => $this->updated_at,
            'user_id' => $this->user_id ,
            'user name'=>$this->user_id  ? $this->user->name :'not found',
            'is_favorite' => $user ? $user->favorites->contains($this->id) : false,
            'favorite_count'=>$this->favoritedBy->count(),
        ];
    }
}
