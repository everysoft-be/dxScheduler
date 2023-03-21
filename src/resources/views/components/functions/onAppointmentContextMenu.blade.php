<script>
    function onAppointmentContextMenu(e)
    {
        console.log("onAppointmentContextMenu");
        console.log(e);

        window.everysoft['currentAppointmentData'] = e.appointmentData;
        $('#everysoft_scheduler_menu').dxContextMenu({
            dataSource: {!! json_encode($eventMenuItem) !!},
            width: 200,
            target: e.element,
            onItemClick(options)
            {
                console.log("onAppointmentContextMenu / onItemClick");
                console.log(options);

                if (options.itemData.form != null)
                {
                    const method = _getMethod(options.itemData.form);
                    method(window.everysoft['currentAppointmentData']);
                }
                else
                {
                    window.everysoft['scheduler'].showAppointmentPopup(duplicateEvent(window.everysoft['currentAppointmentData'], null));
                }
            }
        });
    }

    function duplicateEvent(event, newForm)
    {
        current = JSON.parse(JSON.stringify(event));
        current.id = null;
        current.binding = null;
        current.form = newForm;
        return current;
    }
</script>