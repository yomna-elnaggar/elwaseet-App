<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TermsConditions extends Model
{
    use HasFactory;
   	protected $guarded = [];
    //localization
    public function terms_conditions($lang = null){
       $lang= $lang ?? App::getLocale();
       return json_decode($this->terms_conditions)->$lang;
     }
  
}
