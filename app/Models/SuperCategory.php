<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperCategory extends Model 
{
    use HasFactory;
    protected $guarded = [];

    public function categories(){
        return $this->hasMany(Category::class,'supercategory_id');
    }

    //localization

    public function name($lang = null){

    $lang= $lang ?? App::getLocale();

    return json_decode($this->name)->$lang;
    }
}
