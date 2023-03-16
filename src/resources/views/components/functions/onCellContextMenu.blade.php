<script>
    function onCellContextMenu(e)
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
    }
</script>
