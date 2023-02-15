<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use Livewire\Component;

class Calendar extends Component
{
    public array $allows = [];
    public string $currentView = "month";

    public function render()
    {
        return view('dxScheduler::components.calendar');
    }

    public function can(string $right)
    {
        return in_array($right, $this->allows);
    }
}
