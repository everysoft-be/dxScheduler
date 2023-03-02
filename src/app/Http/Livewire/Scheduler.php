<?php

namespace everysoft\scheduler\app\Http\Livewire;

use everysoft\scheduler\app\traits\DefaultParameters;
use Livewire\Component;

class Scheduler extends Component
{
    use DefaultParameters;

    public function render()
    {
        return view('scheduler::components.scheduler');
    }
}