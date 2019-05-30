<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $primaryKey='country_id';
    protected $with=['city'];

    public function city()
    {
        return $this->hasMany(City::class,'country_id','country_id');
    }

    public function company()
    {
        return $this->hasMany(Company::class,'company_id','company_id');
    }
}
