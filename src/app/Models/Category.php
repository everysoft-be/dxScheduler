<?php

namespace everysoft\dxScheduler\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereNull(string $string)
 */
class Category extends Model
{
    use SoftDeletes;

    protected $table = "everysoft_dxscheduler_categories";
    protected $guarded = [];

}