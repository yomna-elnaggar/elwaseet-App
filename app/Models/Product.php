<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $casts = [
        'images' =>'array'
    ];

    
     public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subCategory(){
        return $this->belongsTo(SubCategory::class,'subcategory_id');
    }

    public function files(){

        return $this->hasMany(File::class);
    }
    
     //localization

    public function name($lang = null){

        $lang= $lang ?? App::getLocale();

        return json_decode($this->name)->$lang;
    }
    
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id')->withTimestamps();
    }
    
    public function user(){
       
        return $this->belongsTo(User::class,'user_id');
        
    }
  
    public function scopeNotBlockedByUser($query, $userId)
    {
        return $query->whereDoesntHave('user.blocksReceived', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }
  
  	public function government(){
        return $this->belongsTo(Government::class,'government_id');
    }
    
  	public function state(){
        return $this->belongsTo(State::class,'state_id');
    }

    
}
