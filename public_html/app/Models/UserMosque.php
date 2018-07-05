<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserMosque extends Model
{
   protected $fillable = ['user_id','mosque_id'];

   public $timestamps = false;


   public function users() {
        return $this->belongsToMany( User::class, 'user_id', 'id' );
    }

   
}
