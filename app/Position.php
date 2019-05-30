<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    protected $primaryKey='position_id';

    public function salary()
    {
        return $this->hasMany(Salary::class,'salary_id','position_id');
    }

    public function job()
    {
        return $this->hasMany(Job::class,'job_id','position_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','company_id');
    }
}
