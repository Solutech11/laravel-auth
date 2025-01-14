<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthModel extends Model
{
    //
    protected $table = 'tbl_Auth';

    protected $fillable = [
        'user_id',
        'auth',
    ];

    public function AuthUser(){
        return $this->belongsTo(UserModel::class,'id');
    }
}
