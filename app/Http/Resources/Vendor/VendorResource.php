<?php

namespace App\Http\Resources\Vendor;

use App\Models\Rateing;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      $data = Rateing::where('user_id', $this->id)->get();
            
             $avarageStar = 0;
            if($data->count()>0){
               $avarageStar = round($data->sum('rate')/$data->count()); 
            }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => url('public/'.$this->image),
           	'government'=>$this->government_id? $this->government->name() :'not found',
            'state'=>$this->state_id? $this->state->name() :'not found',
            'mobile_number' => $this->mobile_number,
            'join date' => $this->created_at,
          	'avarageStar' =>$avarageStar,
          	'Verified'	=> $this->Verified	
        ];
    }
}
