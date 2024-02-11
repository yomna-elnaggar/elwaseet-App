<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

   
    protected $guarded = [];


    public function superCategory(){
        return $this->belongsTo(SuperCategory::class,'supercategory_id');
    }
    
    public function subCategory(){
        return $this->hasMany(SubCategory::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
//localization

    public function name($lang = null){

        $lang= $lang ?? App::getLocale();

        return json_decode($this->name)->$lang;
    }
}
