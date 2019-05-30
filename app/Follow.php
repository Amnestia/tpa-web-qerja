<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    //
    protected $primaryKey='follow_id';

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id','company_id');
    }
}
