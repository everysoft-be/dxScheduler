<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use everysoft\dxScheduler\app\Models\Category;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Calendar extends Component
{
    public array $allows = [];
    public string $currentView = "month";
    public array $references = [];
    public array $categories = [];
    public string $schedulersRouteName = "everysoft.dxscheduler.schedulers.json";
    public string $eventsRouteName = "everysoft.dxscheduler.events.json";
    public string $eventsUpdateRouteName = "everysoft.dxscheduler.events.update";
    public string $eventsDeleteRouteName = "everysoft.dxscheduler.events.delete";
    public array $cellMenuItem = [];
    public array $eventMenuItem = [];

    public function render() : Application | Factory | View
    {
        $this->initReferences();
        $this->initCategories();

        return view('dxScheduler::components.calendar');
    }

    public function can(string $right) : bool
    {
        return in_array($right, $this->allows);
    }

    private function initReferences()
    {
        $route = Route::getRoutes()->getByName($this->schedulersRouteName);
        if(!$route) return;

        $controller = $route->getController();
        $method = $route->getActionMethod();
        $items = $controller->$method(new Request());
        $this->references = [];
        foreach($items as $item)
        {
            $this->references[] = $item->reference;
        }
    }

    private function initCategories()
    {
        foreach(Category::whereNull('user_id')->get() as $category)
        {
            $this->categories[] = $category->id;
        }
    }
}
