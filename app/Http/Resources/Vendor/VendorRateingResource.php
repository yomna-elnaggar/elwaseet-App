<?php

namespace App\Http\Resources\Vendor;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorRateingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $vendor = $this->resource;
        $Evaluator = User::select('name','image')->where('id',$vendor->auth_id)->first();
        
        return [
            'comment'=>$vendor->comment,
            'rate' => $vendor->rate,
            'user_id'=>$vendor->user_id,
            'Evaluator '=> [
                'Evaluator name'=> $Evaluator->name
            ,   'Evaluator image' => url('public/'.$Evaluator->image)
                ],
         
            ];
    }
}
