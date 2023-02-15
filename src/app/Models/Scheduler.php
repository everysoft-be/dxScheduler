<?php

namespace everysoft\dxScheduler\app\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scheduler extends Model
{
    use SoftDeletes;

    protected $table = "everysoft_dxscheduler_schedulers";
    protected $guarded = [];

    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}