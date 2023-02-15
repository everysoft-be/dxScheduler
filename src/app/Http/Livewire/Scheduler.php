<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use Livewire\Component;

class Scheduler extends Component
{
    public string $ref = "1";
    public string $routeName = "everysoft.dxscheduler.schedulers.json";
    public array $allows = [];
    public string $currentView = "month";

    public function render()
    {
        return view('dxScheduler::components.scheduler');
    }
}