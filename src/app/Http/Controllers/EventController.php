<?php

namespace everysoft\dxScheduler\app\Http\Controllers;

use App\Http\Controllers\Controller;
use everysoft\dxScheduler\app\Helpers\SchedulersHelper;
use everysoft\dxScheduler\app\Http\Resources\EventResource;
use everysoft\dxScheduler\app\Models\Event;
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
            if ($request->values)
            {
                $parent = null;
                if ($request->key)
                {
                    // Récupération de l'évènement principale
                    $parent = Event::findOrFail($request->key);
                    if ($parent->parent_id)
                    {
                        $parent = Event::findOrFail($parent->parent_id);
                    }
                }

                // Récupération des valeurs
                $values = json_decode($request->values);
                $datas = [
                    'text'                 => $values->text,
                    'description'          => $values->description,
                    'start_date'           => $values->startDate,
                    'end_date'             => $values->endDate,
                    'all_day'              => $values->allDay ?? null,
                    'recurrence_rule'      => $values->recurrenceRule ?? null,
                    'recurrence_exception' => $values->recurrenceException ?? null,
                    'category_id'          => $values->category_id,
                ];

                if ($parent !== null)
                {
                    $parent->update($datas);
                    foreach ($parent->events as $child)
                    {
                        if (!in_array($child->scheduler_id, $values->scheduler_ids) && (!in_array($parent->scheduler_id, $values->scheduler_ids)))
                        {
                            // Suppression des enfants si nécessaire
                            $child->delete();
                        }
                        else
                        {
                            // Mise à jour
                            $child->update($datas);
                        }
                    }
                }

                // Ajout si n'existe pas
                foreach ($values->scheduler_ids as $scheduler_id)
                {
                    if ($parent->events()->where('scheduler_id', $scheduler_id)->count() === 0)
                    {
                        $datas['scheduler_id'] = $scheduler_id;
                        $datas['created_by'] = Auth::id();
                        $datas['parent_id'] = $parent?->id;
                        Event::create($datas);
                    }
                }
            }

            return new Response("Success", 200);
        }
        catch (\Exception $ex)
        {
            return new Response($ex->getMessage(), 500);
        }
    }

    public function events_delete(Request $request)
    {
        try
        {
            $event = Event::findOrFail($request->key);
            Event::where('parent_id', $event->id)->delete();
            if ($event->parent_id)
            {
                Event::where('parent_id', $event->parent_id)->delete();
            }
            $event->delete();
            return new Response("Success", 200);
        }
        catch (\Exception $ex)
        {
            return new Response($ex->getMessage(), 500);
        }
    }
}