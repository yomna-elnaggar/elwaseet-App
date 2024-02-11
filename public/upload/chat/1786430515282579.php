<?php
namespace App\Http\Resources\User;

use App\Models\Country;
use App\Models\Government;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $user = $this->resource;

        $country_code = $user['country_code'];
        $country = Country::where('country_code', $country_code)->first();
        if($country){
            $government = Government::where('country_id', $country->id)->get();
            $formattedGovernment = $government->map(function ($gov) {
                return [
                     'id'=> $gov? $gov->id :null,
                    'name' => $gov->name()??null,
                ];
            });
    
            return [
                'id' => $user->id,
                'name' => $user->name,
                'mobile_number' => $user->mobile_number,
                 'email' => $user->email,
                'image'=>url('public/'.$user->image),
                'birth_date'=>$user->birth_date?$user->birth_date: null,
                'gender' => $user->gender?$user->gender : null,
                'country'=>$country->name(),
                'country_code' => $user->country_code,
                'government' => $formattedGovernment
            ];
        }else{
            return [
                'id' => $user->id,
                'name' => $user->name,
                'mobile_number' => $user->mobile_number,
                'email' => $user->email,
                'image'=>url('public/'.$user->image),
                 'birth_date'=>$user->birth_date?$user->birth_date: null,
                 'gender' => $user->gender?$user->gender : null,
                 'country'=>'not found',
                'country_code' => $user->country_code,
                
            ]; 
        }
        
    }
}

