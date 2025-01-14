<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    //
    protected $table='tbl_user';

    protected $fillable = [
        'email',
        'username',
        'password'
    ];

    public function userAuth(){
        return $this->hasOne(AuthModel::class,"user_id");
    }
}
