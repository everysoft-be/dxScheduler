<script>
    function appointmentTooltipTemplate(model, index, element)
    {
        div = $("<div>").addClass('row');
        divInfo = $("<div>").addClass('col');
        // Show Calendar name
        @if(count($references) > 1) // Show only if multi calendars view
        if (model.appointmentData.scheduler_name)
        {
            divInfo.append("<B>" + model.appointmentData.scheduler_name + "</B><BR>");
        }
        @endif

        // Show detail
        if (model.appointmentData.text)
        {
            divInfo.append(model.appointmentData.text + "<BR>");
        }

        // Show time
        let startAt = new Date(model.appointmentData.startDate).toLocaleTimeString("fr-fr", {
            hour: '2-digit',
            minute: '2-digit'
        });
        let endAt = new Date(model.appointmentData.endDate).toLocaleTimeString("fr-fr", {
            hour: '2-digit',
            minute: '2-digit'
        });
        divInfo.append(startAt + " - " + endAt + "<BR>");

        // Show description
        if (model.appointmentData.description)
        {
            divInfo.append(model.appointmentData.description);
        }

        div.append(divInfo);

        divRow = $("<div>").addClass('row').attr('style', 'margin-top: 2px; margin-left: 2px; border-top: 1px lightgray solid;');
        divBottom = $("<div>").addClass('col');
        btnEvent = $("<div>")
            .addClass('btn btn-outline-primary border-0')
            .attr('title','Create event from this')
            .append("<i class='dx-icon dx-icon-event'></i>")
            .click( e=>{
                window.cancelAppointmentFormOpening=true;
                alert("Event from: " + model.appointmentData.id);
            });
        btnEDT = $("<div>")
            .addClass('btn btn-outline-primary border-0')
            .attr('title','Create EDT from this')
            .append("<i class='dx-icon fa fa-layer-group'></i>")
            .click( e=>{
                window.cancelAppointmentFormOpening=true;
                alert("EDT from: " + model.appointmentData.id);
            });
        btnEval = $("<div>")
            .addClass('btn btn-outline-primary border-0')
            .attr('title','Create Eval from this')
            .append("<i class='dx-icon fa fa-clipboard'></i>")
            .click( e=>{
                window.cancelAppointmentFormOpening=true;
                alert("Eval from: " + model.appointmentData.id);
            });

        divBottom.append(btnEvent);
        divBottom.append(btnEDT);
        divBottom.append(btnEval);

        divRow.append(divBottom);

        element.append(div);
        element.append(divRow);
    }
</script>