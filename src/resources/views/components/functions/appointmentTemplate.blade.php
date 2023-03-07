<script>
    function appointmentTemplate(model)
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
    }
</script>