<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use everysoft\dxScheduler\app\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

    public function render()
    {
        $this->getReferences();
        $this->getCategories();

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

    private function getCategories()
    {
        foreach(Category::whereNull('user_id')->get() as $category)
        {
            $this->categories[] = $category->id;
        }
    }
}
