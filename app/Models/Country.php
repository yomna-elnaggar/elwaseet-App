<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function government(){
        return $this->hasMany(Government::class);
    }

    public function state(){
        return $this->hasMany(State::class,'country_id');
    }
    
    //localization

    public function name($lang = null){

        $lang= $lang ?? App::getLocale();

        return json_decode($this->name)->$lang;
    }
}
