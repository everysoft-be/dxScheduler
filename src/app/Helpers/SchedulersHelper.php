<?php

namespace everysoft\scheduler\app\Helpers;

use Carbon\Carbon;
use everysoft\scheduler\app\Models\Scheduler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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

    public static function getEvents(array $references = [], $filter = null, $categories = null)
    {
        if(count($references) === 0) return [];
        $events = collect();
        $schedulers = self::getSchedulers($references, false);

        foreach ($schedulers as $scheduler)
        {
            $query = self::decodeFilter($scheduler->events(), $filter);

            $query->where(function($query) use($schedulers)
                {
                    $query->WhereNotIn('parent_id', $schedulers->pluck('id'));
                    $query->orWhereNull('parent_id');
                });
            if($categories !== null)
            {
                $query->whereIn('category_id', $categories);
            }
            $sch_events = $query->get();

            $events = $events->merge($sch_events);

        }

        return $events;
    }

    private static function decodeFilter($query, string|array|null $filters)
    {
        try
        {
            if($filters === null || empty($filters))
            {
                return $query;
            }

            if (!is_array($filters))
            {
                $explodes = explode(',"or",', $filters);
                foreach ($explodes as $explode)
                {
                    $query->where(function ($subquery) use ($explode)
                    {
                        self::decodeFilter($subquery, json_decode($explode));
                    });
                }
                return $query;
            }

            foreach ($filters as $filter)
            {

                if (!is_array($filter[0]) && str_contains($filter[0], 'Date') && count($filter) === 3)
                {
                    // ['endDate', '>=' '3/26/2023']
                    $filter = self::renameFilter($filter);
                    $query->where($filter[0], $filter[1], new Carbon($filter[2]));
                }
                elseif ($filter[0] === 'recurrenceRule')
                {
                    $filter = self::renameFilter($filter);
                    $query->where($filter[0], $filter[1], $filter[2]);
                }
                else
                {
                    continue;
                    self::decodeFilter($query, $filter);
                }
            }
        }
        catch (\Exception $ex)
        {
            dd($ex);
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
        }
        return $query;
    }

    private static function renameFilter($filters)
    {
        if ($filters[0] === 'endDate')
        {
            $filters[0] = 'end_date';
        }
        elseif ($filters[0] === 'startDate')
        {
            $filters[0] = 'start_date';
        }
        elseif ($filters[0] === 'recurrenceRule')
        {
            $filters[0] = 'recurrence_rule';
        }

        if ($filters[1] === 'startswith')
        {
            $filters[1] = 'like';
            $filters[2] .= '%';
        }

        return $filters;
    }
}