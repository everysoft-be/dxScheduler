<?php

namespace everysoft\scheduler\app\Http\Livewire;

use everysoft\scheduler\app\Models\Category;
use everysoft\scheduler\app\traits\DefaultParameters;
use Illuminate\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Calendar extends Component
{
    use DefaultParameters;

    public function render(): Application|Factory|View
    {
        $this->initReferences();
        $this->initCategories();

        return view('scheduler::components.calendar');
    }

    private function initReferences()
    {
        if (count($this->references) > 0) { return; }

        $route = Route::getRoutes()->getByName($this->schedulersRouteName);
        if (!$route)
        {
            return;
        }

        $controller = $route->getController();
        $method = $route->getActionMethod();
        $parameters = "";
        foreach($this->schedulersRouteNameAttributes as $parameter)
        {
            if($parameters) $parameters.= ",";
            $parameters .= $parameter;
        }
        $items = $controller->$method($parameters);
        $this->references = [];
        foreach ($items as $item)
        {
            $this->references[] = $item->reference;
        }
    }

    private function initCategories()
    {
        foreach (Category::whereNull('user_id')->get() as $category)
        {
            $this->categories[] = $category->id;
        }
    }
}
