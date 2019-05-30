<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
