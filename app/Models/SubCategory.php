<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;


    protected $guarded = [];
   

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function superCategory(){
        return $this->belongsTo(SuperCategory::class,'supercategory_id');
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
