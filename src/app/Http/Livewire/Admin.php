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

class Admin extends Component
{
    public function render(): Application|Factory|View
    {
        return view('scheduler::components.admin');
    }
}