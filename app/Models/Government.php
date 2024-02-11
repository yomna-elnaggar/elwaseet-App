<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Government extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    
    //localization

    public function name($lang = null){

        $lang= $lang ?? App::getLocale();

        return json_decode($this->name)->$lang;
    }
  
  	public function products(){
        return $this->hasMany(Product::class,'government_id	');
    }

}
