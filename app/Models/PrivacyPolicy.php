<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;
    protected $guarded = [];
     //localization
    public function privacy_policy($lang = null){
       $lang= $lang ?? App::getLocale();
       return json_decode($this->privacy_policy)->$lang;
      }
}
