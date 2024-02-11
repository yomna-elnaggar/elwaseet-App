<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;

class UserUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->resource;
        $country_code = $user['country_code'];
        $country = Country::where('country_code', $country_code)->first();
        return [
            'id' => $user->id,
            'name' => $user->name,
            'mobile_number' => $user->mobile_number,
            'email' => $user->email,
            'gender' => $user->gender,
            'birth_date'=>$user->birth_date,
            'image'=>url('public/'.$user->image),
            'country'=>$country?$country->name():null,
            'country_code' => $user->country_code?$user->country_code:null,
            'government'=>$this->government_id? $this->government->name() :'not found',
            'state'=>$this->state_id? $this->state->name() :'not found',
            
        ];
    }
}
