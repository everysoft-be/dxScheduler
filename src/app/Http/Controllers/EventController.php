<?php

namespace everysoft\dxScheduler\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use everysoft\dxScheduler\app\Helpers\SchedulersHelper;
use everysoft\dxScheduler\app\Http\Resources\EventResource;
use everysoft\dxScheduler\app\Models\Scheduler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct ()
    {
        $this->middleware(['web', 'auth']);
    }

    public function json(Request $request)
    {
        $references = explode(',', trim($request->references, "[]"));
        $events = SchedulersHelper::getEvents($references??[], $request->filter);

        return EventResource::collection($events);
    }
}