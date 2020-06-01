<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Providers;
class Products extends Model
{
    protected $fillable =['name','description','mime','original_filename','type'];

    public function createByUser(){
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function relatebyProvider(){
        return $this->belongsTo(Providers::class, 'provider_id','id');
    }
}
