<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //
    protected $primaryKey='currency_id';

    public function salary()
    {
        return $this->hasMany(Salary::class,'currency_id','currency_id');
    }

    public function currency()
    {
        return $this->hasMany(Job::class,'currency_id','currency_id');
    }
}
