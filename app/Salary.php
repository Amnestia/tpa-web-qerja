<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    //
    protected $primaryKey='salary_id';

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','company_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class,'position_id','position_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class,'review_id','salary_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class,'period_id','period_id');
    }

    public function salary_period()
    {
        return $this->belongsTo(SalaryPeriod::class,'salary_period_id','salary_period_id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class,'currency_id','currency_id');
    }

}
