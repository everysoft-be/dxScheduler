<?php

namespace everysoft\scheduler\app\traits;

trait DefaultParameters
{
    public string $ref                             = "1";
    public array  $references                      = [];
    public array  $categories                      = [];

    public string $schedulersRouteName             = 'everysoft.scheduler.schedulers.json';
    public array  $schedulersRouteNameAttributes   = [];
    public string $eventsRouteName                 = 'everysoft.scheduler.events.json';
    public array  $eventsRouteNameAttributes       = [];
    public string $eventsUpdateRouteName           = 'everysoft.scheduler.events.update';
    public array  $eventsUpdateRouteNameAttributes = [];
    public string $eventsDeleteRouteName           = 'everysoft.scheduler.events.delete';
    public array  $eventsDeleteRouteNameAttributes = [];

    public string $appointmentTemplate = 'scheduler::components.functions.appointmentTemplate';
    public string $appointmentTooltipTemplate = 'scheduler::components.functions.appointmentTooltipTemplate';
    public string $onAppointmentContextMenu = 'scheduler::components.functions.onAppointmentContextMenu';
    public string $onAppointmentFormOpening = 'scheduler::components.functions.onAppointmentFormOpening';
    public string $onCellContextMenu = 'scheduler::components.functions.onCellContextMenu';

    public array  $allows        = [];
    public string $currentView   = "month";
    public array  $createButton  = [];
    public array  $cellMenuItem  = [];
    public array  $eventMenuItem = [];

    public function can(string $right): bool
    {
        return in_array($right, $this->allows);
    }

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

        $parameters['appointmentTemplate'] = $this->appointmentTemplate;
        $parameters['appointmentTooltipTemplate'] = $this->appointmentTooltipTemplate;
        $parameters['onAppointmentContextMenu'] = $this->onAppointmentContextMenu;
        $parameters['onAppointmentFormOpening'] = $this->onAppointmentFormOpening;
        $parameters['onCellContextMenu'] = $this->onCellContextMenu;

        $parameters['allows'] = $this->allows;
        $parameters['currentView'] = $this->currentView;
        $parameters['createButton'] = $this->createButton;
        $parameters['cellMenuItem'] = $this->cellMenuItem;
        $parameters['eventMenuItem'] = $this->eventMenuItem;

        return $parameters;
    }
}