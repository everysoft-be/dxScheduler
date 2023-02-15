<?php

namespace everysoft\dxScheduler\app\Http\Livewire;

use everysoft\dxScheduler\app\Http\Controllers\SchedulerController;
use everysoft\dxScheduler\app\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Contracts\Foundation\Application;
use \Illuminate\Contracts\View\Factory;
use \Illuminate\Contracts\View\View;

class Navigation extends Component
{
    public array $allows = [];
    public array $objectsCreate = [];
    public string $routeName = "everysoft.dxscheduler.schedulers.json";

    public function render() : Application|Factory|View
    {
        return view('dxScheduler::components.navigation')
            ->with('menuItems', $this->getMenuItems());
    }

    private function getMenuItems() : array
    {
        $array = [];
        $array [] =
            [
                'label' => 'My calendars',
                'items' => $this->getSchedulers(),
            ];

        $array [] =
            [
                'label' => 'Categories',
                'items' => $this->getCategories(),
            ];

        return $array;
    }

    private function getSchedulers()
    {
        $route = Route::getRoutes()->getByName($this->routeName);
        if(!$route) return [];

        $controller = $route->getController();
        $method = $route->getActionMethod();
        return $controller->$method(new Request());
    }

    private function getCategories() : array
    {
        $categories = Category::where('user_id', Auth::id())->orWhereNull('user_id')->orderBy('label', 'asc')->get();
        $items = [];
        foreach($categories as $category)
        {
            $items[] =
                [
                    'id' => $category->id,
                    'label' => $category->label,
                    'description' => $category->description,
                    'text_color' => $category->text_color,
                    'background_color' => $category->background_color,
                    'scheduler_id' => $category->scheduler_id,
                ];
        }
        return $items;
    }

    public function can(string $right)
    {
        return in_array($right, $this->allows);
    }
}
