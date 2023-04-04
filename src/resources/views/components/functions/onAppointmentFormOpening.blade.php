<script>
    window.cancelAppointmentFormOpening=false;
    function onAppointmentFormOpening(options)
    {
        window.everysoft['currentAppointmentData'] = JSON.parse(JSON.stringify(options.appointmentData));

        if(window.cancelAppointmentFormOpening)
        {
            options.cancel = true;
            window.cancelAppointmentFormOpening=false;
            return;
        }

        const canCreate = {{ $this->can('create')?'true':'false' }};
        const canUpdate = {{ $this->can('update')?'true':'false' }};

        if (options.appointmentData.id !== null && !canUpdate)
        {
            options.cancel = true;
            return;
        }

        if (options.appointmentData.id === null && !canCreate)
        {
            options.cancel = true;
            return;
        }

        if (options.appointmentData.form)
        {
            options.cancel = true;
            const method = _getMethod(options.appointmentData.form);
            method(false);
        }
    }
</script>