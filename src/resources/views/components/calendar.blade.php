<style>
    .dx-scheduler-appointment-content {
        padding: 0px;
    }

    .scheduler-appointment-template {
        height: 100%;
        padding-left: 3px;
    }
</style>
<div id="everysoft_scheduler_menu"></div>
<div id="everysoft_scheduler_calendar" style="height: inherit"></div>

@include('scheduler::components.functions.appointmentTemplate')
@include('scheduler::components.functions.appointmentTooltipTemplate')
@include('scheduler::components.functions.onAppointmentContextMenu')
@include('scheduler::components.functions.onAppointmentFormOpening')
@include('scheduler::components.functions.onCellContextMenu')

<script>
    DevExpress.setTemplateEngine('underscore');
    if (!window.everysoft)
    {
        window.everysoft = [];
    }
    window.everysoft['scheduler_references'] = {!! json_encode($references) !!};
    window.everysoft['scheduler_categories'] = {!! json_encode($categories) !!};

    function createSchedulerStore()
    {
        return DevExpress.data.AspNet.createStore({
            key: 'id',
            loadUrl: '{!! route($eventsRouteName, $eventsRouteNameAttributes) !!}',
            insertUrl: '{!! route($eventsUpdateRouteName, $eventsUpdateRouteNameAttributes) !!}',
            updateUrl: '{!! route($eventsUpdateRouteName, $eventsUpdateRouteNameAttributes) !!}',
            deleteUrl: '{!! route($eventsUpdateRouteName, $eventsUpdateRouteNameAttributes) !!}',
            loadParams:
                {
                    references: window.everysoft['scheduler_references'],
                    categories: window.everysoft['scheduler_categories'],
                }
        });
    }

    schedulers = [
            @foreach(\everysoft\scheduler\app\Models\Scheduler::whereIn('reference', $references)->get() as $scheduler)
        {
            id: {!! $scheduler->id !!},
            text: "{!! $scheduler->label !!}",
            color: "{!! $scheduler->background_color !!}"
        },
        @endforeach
    ];

    categories = [
            @foreach(\everysoft\scheduler\app\Models\Category::whereNull('user_id')->get() as $category)
        {
            id: {!! $category->id !!},
            text: "{!! $category->label !!}",
            color: "{!! $category->background_color !!}",
        },
        @endforeach
    ];

    $(function ()
    {
        window.everysoft['scheduler'] = $("#everysoft_scheduler_calendar").dxScheduler({
            dataSource: createSchedulerStore(),
            remoteFiltering: true,
            views:
                [
                    'agenda',
                    'day',
                    'week',
                    'workWeek',
                    'month'
                ],
            currentView: '{{ $currentView }}',
            //adaptivityEnabled: true,
            shadeUntilCurrentTime: true,
            firstDayOfWeek: 1,
            showCurrentTimeIndicator: true,
            maxAppointmentsPerCell: 'auto',
            scrolling:
                {
                    mode: 'virtual',
                },
            resources: [
                {
                    fieldExpr: 'category_id',
                    dataSource: categories,
                    label: 'category',
                },
                {
                    fieldExpr: 'scheduler_ids',
                    dataSource: schedulers,
                    label: 'scheduler',
                    allowMultiple: true,
                },
                {
                    fieldExpr: 'scheduler_id',
                    dataSource: schedulers,
                    label: 'Main scheduler',
                    useColorAsDefault: true,
                }
            ],
            editing:
                {
                    allowAdding: {!! $this->can('create')?'true':'false' !!},
                    allowUpdating: {!! $this->can('update')?'true':'false' !!},
                    allowDragging: {!! $this->can('update')?'true':'false' !!},
                    allowResizing: {!! $this->can('update')?'true':'false' !!},
                    allowDeleting: {!! $this->can('delete')?'true':'false' !!},
                },
            appointmentTemplate: appointmentTemplate,
            appointmentTooltipTemplate: appointmentTooltipTemplate,
            onAppointmentFormOpening: onAppointmentFormOpening,
            onCellContextMenu: onCellContextMenu,
            onAppointmentContextMenu: onAppointmentContextMenu,
        }).dxScheduler('instance');

        // Move view to center
        {
            date = window.everysoft['scheduler'].option('currentDate');
            date.setHours(12);
            window.everysoft['scheduler'].scrollTo(date);
        }
    });
</script>

@include('scheduler::components.forms.eventForm')