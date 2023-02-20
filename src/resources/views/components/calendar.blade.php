<style>
    .dx-scheduler-appointment-content
    {
        padding: 0px;
    }

    .dxscheduler-appointment-template
    {
        height: 100%;
        padding-left: 3px;
    }
</style>
<div id="everysoft_dxScheduler_calendar"></div>

<script>
    if (!window.everysoft)
    {
        window.everysoft = [];
    }
    window.everysoft['dxScheduler_references'] = {!! json_encode($references) !!};

    function createSchedulerStore()
    {
        return DevExpress.data.AspNet.createStore({
            key: 'id',
            loadUrl: '{!! route($eventsRouteName) !!}',
            loadParams:
                {
                    references: window.everysoft['dxScheduler_references']
                }
        });
    }

    schedulers = [
        @foreach(\everysoft\dxScheduler\app\Models\Scheduler::whereIn('reference', $references)->get() as $scheduler)
        {
            id: {!! $scheduler->id !!},
            text: "{!! $scheduler->label !!}",
            color: "{!! $scheduler->background_color !!}"
        },
        @endforeach
    ];

    categories = [
        @foreach(\everysoft\dxScheduler\app\Models\Category::whereNull('user_id')->get() as $category)
        {
            id: {!! $category->id !!},
            text: "{!! $category->label !!}",
            color: "{!! $category->background_color !!}",
        },
        @endforeach
    ];

    $(function ()
    {
        window.everysoft['dxScheduler'] = $("#everysoft_dxScheduler_calendar").dxScheduler({
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
                    fieldExpr: 'scheduler_id',
                    dataSource: schedulers,
                    label: 'scheduler',
                },
            ],
            editing:
                {
                    allowAdding: {!! $this->can('create')?'true':'false' !!},
                    allowUpdating: {!! $this->can('update')?'true':'false' !!},
                    allowDragging: {!! $this->can('update')?'true':'false' !!},
                    allowResizing: {!! $this->can('update')?'true':'false' !!},
                    allowDeleting: {!! $this->can('delete')?'true':'false' !!},
                },
            appointmentTemplate(model)
            {
                let startAt = new Date(model.appointmentData.startDate);
                let endAt = new Date(model.appointmentData.endDate);
                div = $("<div>")
                    .css('border-left', '1rem solid ' + model.appointmentData.category_background_color)
                    .addClass('dxscheduler-appointment-template')
                    //.append(model.appointmentData.category_label + "<BR>")
                    .append("<B>")
                    .append(model.appointmentData.scheduler_name)
                    .append(" : ")
                    .append(model.appointmentData.text)
                    .append("</B>")
                    .append("<br>")
                    .append("<small>" + startAt.getHours() + ":" + startAt.getMinutes())
                    .append(" - ")
                    .append(+ endAt.getHours() + ":" + endAt.getMinutes() + "</small")
                    .append("<br>")
                    .append(model.appointmentData.description);


                return div;
            },
        }).dxScheduler('instance');

        // Move view to center
        {
            date = window.everysoft['dxScheduler'].option('currentDate');
            date.setHours(12);
            window.everysoft['dxScheduler'].scrollTo(date);
        }
    });
</script>
