<?php

namespace everysoft\scheduler;

use Carbon\Laravel\ServiceProvider;
use everysoft\scheduler\app\Http\Livewire\Calendar;
use everysoft\scheduler\app\Http\Livewire\Navigation;
use everysoft\scheduler\app\Http\Livewire\Scheduler;
use everysoft\scheduler\app\View\Components\CalendarComponent;
use everysoft\scheduler\app\View\Components\NavigationComponent;
use everysoft\scheduler\app\View\Components\SchedulerComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class schedulerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->afterResolving(BladeCompiler::class, static function()
        {
            if (config('jetstream.stack') === 'livewire' && class_exists(Livewire::class))
            {
                Livewire::component('everysoft-scheduler', Scheduler::class);
                Livewire::component('everysoft-scheduler-calendar', Calendar::class);
                Livewire::component('everysoft-scheduler-navigation', Navigation::class);
            }
        });
    }

    public function boot(): void
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/lang', 'scheduler');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'scheduler');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

}
