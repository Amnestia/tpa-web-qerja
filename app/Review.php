<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    //
    protected $primaryKey='review_id';

    public function salary()
    {
        return $this->belongsTo(Salary::class,'salary_id','salary_id');
    }

    public function helpful()
    {
        return $this->hasMany(Helpful::class,'review_id','review_id');
    }
}
