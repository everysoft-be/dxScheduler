<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use Livewire\Component;
use PharIo\Manifest\Application;

class Scheduler extends Component
{
    public string $ref = "1";
    public array $references=[];
    public string $schedulersRouteName = "everysoft.dxscheduler.schedulers.json";
    public string $eventsRouteName = "everysoft.dxscheduler.events.json";
    public string $eventsUpdateRouteName = "everysoft.dxscheduler.events.update";
    public string $eventsDeleteRouteName = "everysoft.dxscheduler.events.delete";
    public array $allows = [];
    public string $currentView = "month";
    public array $createButton = [];
    public array $cellMenuItem = [];
    public array $eventMenuItem = [];

    public function render()
    {
        return view('dxScheduler::components.scheduler');
    }
}