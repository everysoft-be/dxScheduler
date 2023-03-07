<script>
    function appointmentTooltipTemplate(model)
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
    }
</script>