<?php

namespace everysoft\scheduler\app\Http\Controllers;

use App\Http\Controllers\Controller;
use everysoft\scheduler\app\Http\Resources\SchedulerResource;
use everysoft\scheduler\app\Models\Scheduler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SchedulerController extends Controller
{
    public function __construct ()
    {
        $this->middleware(['web', 'auth']);
    }

    public function json(Request $request)
    {
        $schedulers = Scheduler::where('user_id', Auth::id())->get();
        return SchedulerResource::collection($schedulers);
    }
}