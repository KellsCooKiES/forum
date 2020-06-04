<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded =[];


    public function Thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
