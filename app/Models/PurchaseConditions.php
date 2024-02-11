<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class PurchaseConditions extends Model
{
    use HasFactory;
  	protected $guarded = [];
  
   //localization
   public function purchase_conditions($lang = null){
        $lang= $lang ?? App::getLocale();
        return json_decode($this->purchase_conditions)->$lang;
    }
}
