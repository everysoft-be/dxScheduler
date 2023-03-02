<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use everysoft\dxScheduler\app\traits\DefaultParameters;
use Livewire\Component;

class Scheduler extends Component
{
    use DefaultParameters;

    public function render()
    {
        return view('dxScheduler::components.scheduler');
    }
}