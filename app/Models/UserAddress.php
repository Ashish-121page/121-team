<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = ['user_id','details','type'];
    Public function userShop(){
        return $this->hasOne(UserShop::class,'user_id', 'user_id');
    }
}
