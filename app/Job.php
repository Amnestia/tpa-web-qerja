<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //
    protected $primaryKey='job_id';

    public function position()
    {
        return $this->belongsTo(Position::class,'position_id','position_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','currency_id');
    }
}
