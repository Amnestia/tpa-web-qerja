<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalaryPeriod extends Model
{
    //
    protected $primaryKey='salary_period_id';

    public function salary()
    {
        return $this->hasMany(Salary::class,'salary_period_id','salary_period_id');
    }
}
