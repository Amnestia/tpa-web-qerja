<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $primaryKey='city_id';

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','country_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class,'city_id','city_id');
    }
}
