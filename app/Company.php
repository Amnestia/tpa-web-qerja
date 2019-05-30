<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $primaryKey='company_id';
    protected $with=['country','category','city'];

    public function position()
    {
        return $this->hasMany(Position::class,'company_id','company_id');
    }

    public function review()
    {
        return $this->hasMany(Review::class,'company_id','company_id');
    }

    public function salary()
    {
        return $this->hasMany(Salary::class,'company_id','company_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','category_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class,'company_id','country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class,'city_id','city_id');
    }

    public function follow()
    {
        return $this->hasMany(Follow::class,'company_id','company_id');
    }
}
