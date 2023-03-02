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
<script>
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
            loadUrl: '{!! route($eventsRouteName) !!}',
            insertUrl: '{!! route($eventsUpdateRouteName) !!}',
            updateUrl: '{!! route($eventsUpdateRouteName) !!}',
            deleteUrl: '{!! route($eventsUpdateRouteName) !!}',
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
                let startAt = new Date(model.appointmentData.startDate).toLocaleTimeString("fr-fr", {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                let endAt = new Date(model.appointmentData.endDate).toLocaleTimeString("fr-fr", {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div = $("<div>");
                div.attr('title', startAt + " - " + endAt);
                div.css('border-left', '1rem solid ' + model.appointmentData.category_background_color);
                div.addClass('scheduler-appointment-template');
                @if(count($references) > 1)
                if (model.appointmentData.scheduler_name) div.append("<span style='font-size:.6rem'>" + model.appointmentData.scheduler_name + "</span><BR>");
                @endif
                if (model.appointmentData.text) div.append(model.appointmentData.text + "<BR>");
                if (model.appointmentData.description) div.append(model.appointmentData.description);

                return div;
            },
            appointmentTooltipTemplate(model)
            {
                let startAt = new Date(model.appointmentData.startDate).toLocaleTimeString("fr-fr", {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                let endAt = new Date(model.appointmentData.endDate).toLocaleTimeString("fr-fr", {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                div = $("<div>");
                @if(count($references) > 1)
                if (model.appointmentData.scheduler_name) div.append("<B>" + model.appointmentData.scheduler_name + "</B><BR>");
                @endif
                if (model.appointmentData.text) div.append(model.appointmentData.text + "<BR>");
                div.append(startAt + " - " + endAt + "<BR>");
                if (model.appointmentData.description) div.append(model.appointmentData.description);


                return div;
            },
            onAppointmentFormOpening(options)
            {
                if (options.appointmentData.form)
                {
                    options.cancel = true;
                    const method = _getMethod(options.appointmentData.form);
                    method(options.appointmentData);
                }
            },
            onCellContextMenu(e)
            {
                window.everysoft['currentAppointmentData'] = e.cellData;
                $('#everysoft_scheduler_menu').dxContextMenu({
                    dataSource: {!! json_encode($cellMenuItem) !!},
                    width: 200,
                    target: e.element,
                    onItemClick(options)
                    {
                        if (options.itemData.form != null)
                        {
                            const method = _getMethod(options.itemData.form);
                            method(options.cellData);
                        }
                        else
                        {
                            window.everysoft['scheduler'].showAppointmentPopup(window.everysoft['currentAppointmentData']);
                        }
                    }
                });
            },
            onAppointmentContextMenu(e)
            {
                window.everysoft['currentAppointmentData'] = e.appointmentData;
                $('#everysoft_scheduler_menu').dxContextMenu({
                    dataSource: {!! json_encode($eventMenuItem) !!},
                    width: 200,
                    target: e.element,
                    onItemClick(options)
                    {
                        if (options.itemData.form != null)
                        {
                            const method = _getMethod(options.itemData.form);
                            method(options.cellData);
                        }
                        else
                        {
                            window.everysoft['scheduler'].showAppointmentPopup(window.everysoft['currentAppointmentData']);
                        }
                    }
                });
            },
        }).dxScheduler('instance');

        // Move view to center
        {
            date = window.everysoft['scheduler'].option('currentDate');
            date.setHours(12);
            window.everysoft['scheduler'].scrollTo(date);
        }
    });
</script>
