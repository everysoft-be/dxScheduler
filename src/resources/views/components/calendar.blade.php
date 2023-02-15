<div id="everysoft_dxScheduler_calendar"></div>

<script>
    $(function ()
    {
        const params = {'references' : 'users/1,my-school/public/journal,my-school/intern/journal]'};

        if (!window.everysoft){window.everysoft = [];}
        window.everysoft['dxScheduler'] = $("#everysoft_dxScheduler_calendar").dxScheduler({
            dataSource: DevExpress.data.AspNet.createStore({
                key: 'id',
                loadUrl: '{!! route('everysoft.dxscheduler.events.json') !!}',
                loadParams: params,
            }),

            remoteFiltering: true,
            views: ['agenda', 'day', 'week', 'workWeek', 'month'],
            currentView: '{{ $currentView }}',
            shadeUntilCurrentTime: true,
            firstDayOfWeek: 1,
            showCurrentTimeIndicator: true,
            scrolling:
                {
                    mode: 'virtual',
                },
            editing:
                {
                    allowAdding: {!! $this->can('create')?'true':'false' !!},
                    allowUpdating: {!! $this->can('update')?'true':'false' !!},
                    allowDragging: {!! $this->can('update')?'true':'false' !!},
                    allowResizing: {!! $this->can('update')?'true':'false' !!},
                    allowDeleting: {!! $this->can('delete')?'true':'false' !!},
                },
            onAppointmentRendered(event)
            {
                event.appointmentElement.css('background-color', event.appointmentData.background_color);
                event.appointmentElement.css('color', event.appointmentData.text_color);
            }
        }).dxScheduler('instance');

        // Move view to center
        {
            date = window.everysoft['dxScheduler'].option('currentDate');
            date.setHours(12);
            window.everysoft['dxScheduler'].scrollTo(date);
        }
    });
</script>
