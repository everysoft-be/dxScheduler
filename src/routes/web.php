<?php
use \everysoft\scheduler\app\Http\Controllers\SchedulerController;
use \everysoft\scheduler\app\Http\Controllers\EventController;

Route::prefix('everysoft/scheduler')->group(function ()
{
    Route::prefix('schedulers')->group(function ()
    {
        Route::get('json', [SchedulerController::class, 'json'])->name('everysoft.scheduler.schedulers.json');
    });

    Route::prefix('events')->group(function ()
    {
        Route::get('json', [EventController::class, 'json'])->name('everysoft.scheduler.events.json');
        Route::post('update', [EventController::class, 'update'])->name('everysoft.scheduler.events.update');
    });
});
