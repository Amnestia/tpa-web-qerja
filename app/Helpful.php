<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Helpful extends Model
{
    //
    protected $primaryKey='helpful_id';

    public function review()
    {
        return $this->belongsTo(Review::class,'review_id','review_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','user_id');
    }
}
