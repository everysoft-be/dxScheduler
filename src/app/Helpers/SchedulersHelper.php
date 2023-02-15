<?php

namespace everysoft\dxScheduler\app\Helpers;

use Carbon\Carbon;
use everysoft\dxScheduler\app\Models\Scheduler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

abstract class SchedulersHelper
{
    public static function getSchedulers(array $references = [], bool $withMySchedulers = true)
    {
        $schedulers = Scheduler::query();

        $schedulers->where(function ($query) use ($references, $withMySchedulers)
        {
            if ($withMySchedulers)
            {
                $query->where('user_id', Auth::id());
            }

            foreach ($references as $reference)
            {
                $query->orWhere('reference', $reference);
            }
        });

        $schedulers->orderBy('label', 'asc');
        return $schedulers->get();
    }

    public static function getEvents(array $references = [], $filter = null)
    {
        $events = collect();
        $schedulers = self::getSchedulers($references);
        foreach ($schedulers as $scheduler)
        {
            $events = $events->merge(self::decodeFilter($scheduler->events(), $filter)->get());
        }
        return $events;
    }

    private static function decodeFilter($query, $filter)
    {
        try
        {
            if ($filter)
            {
                $filters = json_decode($filter);
                // Evènements journalier
                foreach ($filters[0][0] as $filter)
                {
                    if ($filter[0] === 'endDate')
                    {
                        $filter[0] = 'end_date';
                    }
                    else if ($filter[0] === 'startDate')
                    {
                        $filter[0] = 'start_date';
                    }
                    $query->where($filter[0], $filter[1], new Carbon($filter[2]));
                }
            }
        }
        catch (\Exception $ex)
        {
            Log::warning($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        return $query;
    }
}