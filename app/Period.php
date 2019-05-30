<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    //
    public function salary()
    {
        return $this->hasMany(Salary::class,'salary_id','salary_id');
    }
}
