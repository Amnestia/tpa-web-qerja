<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey="user_id";
    protected $fillable=["name","email","password","verification_code","verified"];

    public function role()
    {
        return $this->hasOne(Role::class,'role_id');
    }
}
