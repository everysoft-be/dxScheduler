<?php

namespace everysoft\scheduler\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static whereNull(string $string)
 */
class Category extends Model
{
    use SoftDeletes;

    protected $table = "everysoft_scheduler_categories";
    protected $guarded = [];

}