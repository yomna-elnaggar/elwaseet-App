<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $guarded = [];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mobile_verified_at' => 'datetime',
        'password' => 'hashed',
       // 'birth_date' => 'datetime:d/m/Y', // Change your format
    ];

    public function product(){
        return $this->hasMany(Product::class);
    }
    
    public function providers()
    {
        return $this->hasMany(Provider::class,'user_id','id');
    }
    
    public function Rateinges(){

        return $this->hasMany(Rateing::class,'user_id');
    }
    
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')->withTimestamps();
    }
    
     public function userPhoneVerified()
    {
    return ! is_null($this->mobile_verified_at);
    }

    public function phoneVerifiedAt()
    {
    return $this->forceFill([
        'mobile_verified_at' => $this->freshTimestamp(),
    ])->save();
    }
    
    
    public function blocksReceived()
    {
        return $this->hasMany(Block::class, 'blocked_user_id');
    }
    
    public function blocks()
    {
        return $this->hasMany(Block::class, 'user_id');
    }
    
     public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'user_id', 'id')
            ->orWhere(function ($query) {
                $query->where('received_id', $this->id);
            });
    }
  
  	public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
  
  	public function government(){
        return $this->belongsTo(Government::class,'government_id');
    }
    
  	public function state(){
        return $this->belongsTo(State::class,'state_id');
    }
  
  	public function mutes()
    {
        return $this->hasMany(Mute::class, 'user_id');
    }
  
   	public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class, 'user_id');
    }
  
	public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
    /* public function routeNotificationForFcm()
    {
        return $this->deviceTokens()->pluck('token')->toArray(); 
    }
   
    public function routeNotificationForDatabase()
    {
        return ['database'];
    }*/
}
