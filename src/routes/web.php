<?php
use \everysoft\dxScheduler\app\Http\Controllers\SchedulerController;
use \everysoft\dxScheduler\app\Http\Controllers\EventController;

Route::prefix('everysoft/dxscheduler')->group(function ()
{
    Route::prefix('schedulers')->group(function ()
    {
        Route::get('json', [SchedulerController::class, 'json'])->name('everysoft.dxscheduler.schedulers.json');
    });

    Route::prefix('events')->group(function ()
    {
        Route::get('json', [EventController::class, 'json'])->name('everysoft.dxscheduler.events.json');
    });
});
