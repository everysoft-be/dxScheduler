<?php

namespace everysoft\dxScheduler\app\traits;

trait DefaultParameters
{
    public string $ref                             = "1";
    public array  $references                      = [];
    public array  $categories                      = [];

    public string $schedulersRouteName             = "everysoft.dxscheduler.schedulers.json";
    public array  $schedulersRouteNameAttributes   = [];
    public string $eventsRouteName                 = "everysoft.dxscheduler.events.json";
    public array  $eventsRouteNameAttributes       = [];
    public string $eventsUpdateRouteName           = "everysoft.dxscheduler.events.update";
    public array  $eventsUpdateRouteNameAttributes = [];
    public string $eventsDeleteRouteName           = "everysoft.dxscheduler.events.delete";
    public array  $eventsDeleteRouteNameAttributes = [];

    public array  $allows        = [];
    public string $currentView   = "month";
    public array  $createButton  = [];
    public array  $cellMenuItem  = [];
    public array  $eventMenuItem = [];

    public function getParameters()
    {
        $parameters = [];

        $parameters['ref'] = $this->ref;
        $parameters['references'] = $this->references;
        $parameters['categories'] = $this->categories;

        $parameters['schedulersRouteName'] = $this->schedulersRouteName;
        $parameters['schedulersRouteNameAttributes'] = $this->schedulersRouteNameAttributes;
        $parameters['eventsRouteName'] = $this->eventsRouteName;
        $parameters['eventsRouteNameAttributes'] = $this->eventsRouteNameAttributes;
        $parameters['eventsUpdateRouteName'] = $this->eventsUpdateRouteName;
        $parameters['eventsUpdateRouteNameAttributes'] = $this->eventsUpdateRouteNameAttributes;
        $parameters['eventsDeleteRouteName'] = $this->eventsDeleteRouteName;
        $parameters['eventsDeleteRouteNameAttributes'] = $this->eventsDeleteRouteNameAttributes;

        $parameters['allows'] = $this->allows;
        $parameters['currentView'] = $this->currentView;
        $parameters['createButton'] = $this->createButton;
        $parameters['cellMenuItem'] = $this->cellMenuItem;
        $parameters['eventMenuItem'] = $this->eventMenuItem;

        return $parameters;
    }
}