<?php

namespace everysoft\scheduler\app\Http\Controllers;

use altiore\calendar\app\Helpers\Events;
use App\Http\Controllers\Controller;
use everysoft\scheduler\app\Helpers\EventsHelper;
use everysoft\scheduler\app\Helpers\SchedulersHelper;
use everysoft\scheduler\app\Http\Resources\EventResource;
use everysoft\scheduler\app\Models\Event;
use Illuminate\Http\Response;
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
        $references = $request->references;
        $categories = $request->categories;

        $filter = substr($request->filter, 2, strlen($request->filter) - 4);
        $events = SchedulersHelper::getEvents($references ?? [], $filter, $categories);

        return EventResource::collection($events);
    }

    public function update(Request $request)
    {
        try
        {
            EventsHelper::updateEventFromRequest($request);

            return new Response("Success", 200);
        }
        catch (\Exception $ex)
        {
            return new Response($ex->getMessage(), 500);
        }
    }

    public function delete(Request $request)
    {
        try
        {
            if($request->has('key'))
            {
                $event = Event::findOrFail($request->key);
                Event::where('parent_id', $event->id)->delete();
                if ($event->parent_id)
                {
                    Event::where('parent_id', $event->parent_id)->delete();
                }
                $event->delete();
            }
            else
            {
                $event = Event::findOrFail($request->id);
                $event->delete();
            }
            return new Response("Success", 200);
        }
        catch (\Exception $ex)
        {
            return new Response($ex->getMessage(), 500);
        }
    }
}