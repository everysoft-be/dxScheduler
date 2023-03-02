<?php

namespace everysoft\dxScheduler;

use Carbon\Laravel\ServiceProvider;
use everysoft\dxScheduler\app\Http\Livewire\Calendar;
use everysoft\dxScheduler\app\Http\Livewire\Navigation;
use everysoft\dxScheduler\app\Http\Livewire\Scheduler;
use everysoft\dxScheduler\app\View\Components\CalendarComponent;
use everysoft\dxScheduler\app\View\Components\NavigationComponent;
use everysoft\dxScheduler\app\View\Components\SchedulerComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class dxSchedulerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->afterResolving(BladeCompiler::class, static function()
        {
            if (config('jetstream.stack') === 'livewire' && class_exists(Livewire::class))
            {
                Livewire::component('everysoft-dxScheduler', Scheduler::class);
                Livewire::component('everysoft-dxScheduler-calendar', Calendar::class);
                Livewire::component('everysoft-dxScheduler-navigation', Navigation::class);
            }
        });
    }

    public function boot(): void
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/lang', 'dxScheduler');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'dxScheduler');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

}
