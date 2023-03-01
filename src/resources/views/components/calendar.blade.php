<style>
    .dx-scheduler-appointment-content {
        padding: 0px;
    }

    .dxscheduler-appointment-template {
        height: 100%;
        padding-left: 3px;
    }
</style>
<div id="everysoft_dxScheduler_menu"></div>
<div id="everysoft_dxScheduler_calendar"></div>
<script>
    if (!window.everysoft)
    {
        window.everysoft = [];
    }
    window.everysoft['dxScheduler_references'] = {!! json_encode($references) !!};
    window.everysoft['dxScheduler_categories'] = {!! json_encode($categories) !!};

    function createSchedulerStore()
    {
        return DevExpress.data.AspNet.createStore({
            key: 'id',
            loadUrl: '{!! route($eventsRouteName) !!}',
            insertUrl: '{!! route($eventsUpdateRouteName) !!}',
            updateUrl: '{!! route($eventsUpdateRouteName) !!}',
            deleteUrl: '{!! route($eventsUpdateRouteName) !!}',
            loadParams:
                {
                    references: window.everysoft['dxScheduler_references'],
                    categories: window.everysoft['dxScheduler_categories'],
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
            appointmentTemplate(model)
            {
                let startAt = new Date(model.appointmentData.startDate).toLocaleTimeString("fr-fr", {hour: '2-digit', minute: '2-digit'});
                let endAt = new Date(model.appointmentData.endDate).toLocaleTimeString("fr-fr", {hour: '2-digit', minute: '2-digit'});
                div = $("<div>")
                    .attr('title', startAt + " - " + endAt)
                    .css('border-left', '1rem solid ' + model.appointmentData.category_background_color)
                    .addClass('dxscheduler-appointment-template')
                    .append("<span style='font-size:.6rem'>" + model.appointmentData.scheduler_name + "</span><BR>")
                    .append(model.appointmentData.text + "<BR>")
                    .append(model.appointmentData.description);

                return div;
            },
            appointmentTooltipTemplate(model)
            {
                let startAt = new Date(model.appointmentData.startDate).toLocaleTimeString("fr-fr", {hour: '2-digit', minute: '2-digit'});
                let endAt = new Date(model.appointmentData.endDate).toLocaleTimeString("fr-fr", {hour: '2-digit', minute: '2-digit'});
                div = $("<div>")
                    .append("<B>@lang('groups.Groups'): </B>"+model.appointmentData.scheduler_name + "<BR>")
                    .append("<B>@lang('subject.Subject'): </B>" + model.appointmentData.text + "<BR>")
                    .append("<B>@lang('EDTs.start_hour'): </B>" + startAt + " - " + endAt + "<BR>")
                    .append(model.appointmentData.description);


                return div;
            },
            onAppointmentFormOpening(options)
            {
                if(options.appointmentData.form)
                {
                    options.cancel = true;
                    const method = _getMethod(options.appointmentData.form);
                    method(options.appointmentData);
                }
            },
            onCellContextMenu(e)
            {
                window.everysoft['currentAppointmentData'] = e.cellData;
                $('#everysoft_dxScheduler_menu').dxContextMenu({
                    dataSource: {!! json_encode($cellMenuItem) !!},
                    width: 200,
                    target: e.element,
                    onItemClick(options)
                    {
                        if(options.itemData.form != null)
                        {
                            const method = _getMethod(options.itemData.form);
                            method(options.cellData);
                        }
                        else
                        {
                            window.everysoft['dxScheduler'].showAppointmentPopup(window.everysoft['currentAppointmentData']);
                        }
                    }
                });
            },
            onAppointmentContextMenu(e)
            {
                window.everysoft['currentAppointmentData'] = e.appointmentData;
                $('#everysoft_dxScheduler_menu').dxContextMenu({
                    dataSource: {!! json_encode($eventMenuItem) !!},
                    width: 200,
                    target: e.element,
                    onItemClick(options)
                    {
                        if(options.itemData.form != null)
                        {
                            const method = _getMethod(options.itemData.form);
                            method(options.cellData);
                        }
                        else
                        {
                            window.everysoft['dxScheduler'].showAppointmentPopup(window.everysoft['currentAppointmentData']);
                        }
                    }
                });
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
