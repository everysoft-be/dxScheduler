<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Scheduler extends Component
{
    public string $ref = "1";
    public string $schedulersRouteName = "everysoft.dxscheduler.schedulers.json";
    public string $eventsRouteName = "everysoft.dxscheduler.events.json";
    public array $allows = [];
    public string $currentView = "month";

    public function render()
    {
        return view('dxScheduler::components.scheduler');
    }
}