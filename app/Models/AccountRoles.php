<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AccountRoles extends Model
{
    use HasFactory;
  
  	protected $guarded = [];
  
   //localization
   	public function account_roles($lang = null){
        $lang= $lang ?? App::getLocale();
        return json_decode($this->account_roles)->$lang;
    }
}
