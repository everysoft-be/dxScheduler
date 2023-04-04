<script>
    function onAppointmentContextMenu(e)
    {
        window.everysoft['currentAppointmentData'] = JSON.parse(JSON.stringify(e.appointmentData));
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
                    method();
                }
                else
                {
                    window.everysoft['scheduler'].showAppointmentPopup();
                }
            }
        });
    }
</script>