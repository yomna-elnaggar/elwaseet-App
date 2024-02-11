<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    
    protected $guarded = [];
   

    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function government(){
        return $this->belongsTo(Government::class,'government_id');
    }

    //localization

    public function name($lang = null){

        $lang= $lang ?? App::getLocale();

        return json_decode($this->name)->$lang;
    }
  
  	public function products(){
        return $this->hasMany(Product::class,'state_id	');
    }
}
