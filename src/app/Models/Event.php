<?php

namespace everysoft\scheduler\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = "everysoft_scheduler_events";
    protected $dates = ['start_date', 'end_date', 'created_at', 'updated_at', 'deleted_at'];
    protected $guarded = [];

    public function scheduler()
    {
        return $this->belongsTo(Scheduler::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'parent_id');
    }

    public function getSchedulerIdsAttribute()
    {
        $events = $this->events()->select('scheduler_id')->get();
        $ids = [];
        foreach($events as $event)
        {
            $ids[] = $event->scheduler_id;
        }
        return $ids;
    }
}
