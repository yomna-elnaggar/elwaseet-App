<?php

namespace App\Http\Controllers\Api\Country;

use App\Models\State;
use App\Models\Country;
use App\Models\Government;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function getGovernment(Request $request){
        
        try{
            $code = $request['code'];
            $country = Country::where('country_code', $code)->first();
            
            if (!$country) {
                return response()->json(['error' => __('message.country_not_found')], 404);
            }
    
            $government = Government::where('country_id', $country->id)->get();
    
            $formattedGovernment = $government->map(function ($gov) {
                return [
                    'id' => $gov->id ?? null,
                    'name' => $gov->name() ?? null,
                ];
            });
    
            $success['data'] = $formattedGovernment;
            $success['success'] = __('message.success');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    
    }

    public function getState($id){
 
        try{
            
            $State = State::where('government_id', $id)->get();
            

            if (!$State) {
                return response()->json(['error' => __('message.country_not_found')], 404);
            }
    
            $formattedState = $State->map(function ($state) {
                return [
                    'id' => $state->id ?? null,
                    'name' => $state->name() ?? null,
                ];
            });
            $success['data'] = $formattedState;
            $success['success'] = __('message.success');
            return response()->json($success, 200);
        } catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
