<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Products;
class providers extends Model
{

    protected $fillable =['name','address','telephone','city'];

    public function createByUser(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
    public function providers(){
        return $this->hasMany(Products::class, 'provider_id', 'id');
    }
}
