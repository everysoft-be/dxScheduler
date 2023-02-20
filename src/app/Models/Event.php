<?php

namespace everysoft\dxScheduler\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = "everysoft_dxscheduler_events";
    protected $guarded = [];

    public function scheduler()
    {
        return $this->belongsTo(Scheduler::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}