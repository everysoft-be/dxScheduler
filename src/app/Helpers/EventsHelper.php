<?php

namespace everysoft\scheduler\app\Helpers;

use everysoft\scheduler\app\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EventsHelper
{
    /** Update */
    public static function updateEventFromRequest(Request $request)
    {
        if ($request->values)
        {
            $values = json_decode($request->values);

            $parent = null;
            if ($request->key && $request->key !== 'null')
            {
                // Récupération de l'évènement principale
                $parent = Event::findOrFail($request->key);
                if ($parent->parent_id)
                {
                    $parent = Event::findOrFail($parent->parent_id);
                }
            }

            // Récupération des valeurs
            $datas = [
                'text'                 => $values->text,
                'description'          => $values->description ?? null,
                'start_date'           => $values->startDate,
                'end_date'             => $values->endDate,
                'all_day'              => $values->allDay ?? 0,
                'recurrence_rule'      => $values->recurrenceRule ?? null,
                'recurrence_exception' => $values->recurrenceException ?? null,
                'category_id'          => $values->category_id,
                'scheduler_id'         => $values->scheduler_id,
                'created_by'           => $values->created_by ?? Auth::id(),
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
            else
            {
                $parent = Event::create($datas);
            }

            // Ajout si n'existe pas
            if(isset($values->scheduler_ids))
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
    }

    /** Delete */
    public static function deleteEventId($event_id)
    {
        $event = Event::findOrFail($event_id);
        self::deleteEvent($event);
    }

    public static function deleteEvent($event)
    {
        Event::where('parent_id', $event->id)->delete();
        if ($event->parent_id)
        {
            Event::where('parent_id', $event->parent_id)->delete();
        }
        $event->delete();
    }
}