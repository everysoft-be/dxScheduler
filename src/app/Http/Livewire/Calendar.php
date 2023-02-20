<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Calendar extends Component
{
    public array $allows = [];
    public string $currentView = "month";
    public array $references = [];
    public string $schedulersRouteName = "everysoft.dxscheduler.schedulers.json";
    public string $eventsRouteName = "everysoft.dxscheduler.events.json";

    public function render()
    {
        $this->getReferences();

        return view('dxScheduler::components.calendar');
    }

    public function can(string $right)
    {
        return in_array($right, $this->allows);
    }

    private function getReferences()
    {
        $route = Route::getRoutes()->getByName($this->schedulersRouteName);
        if(!$route) return [];

        $controller = $route->getController();
        $method = $route->getActionMethod();
        $items = $controller->$method(new Request());
        $this->references = [];
        foreach($items as $item)
        {
            $this->references[] = $item->reference;
        }
    }
}
