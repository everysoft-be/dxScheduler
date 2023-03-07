<script>
    window.cancelAppointmentFormOpening=false;
    function onAppointmentFormOpening(options)
    {
        if(window.cancelAppointmentFormOpening)
        {
            options.cancel = true;
            window.cancelAppointmentFormOpening=false;
        }

        const canCreate = {{ $this->can('create')?'true':'false' }};
        const canUpdate = {{ $this->can('update')?'true':'false' }};

        if (options.appointmentData.id !== null && !canUpdate)
        {
            console.log('cancel update');
            options.cancel = true;
            return;
        }

        if (options.appointmentData.id === null && !canCreate)
        {
            console.log('cancel create');
            options.cancel = true;
            return;
        }

        if (options.appointmentData.form)
        {
            options.cancel = true;
            const method = _getMethod(options.appointmentData.form);
            method(options.appointmentData);
        }
    }
</script>