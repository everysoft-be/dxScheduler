<div id="everysoft-scheduler-eventformpopup">
    <div id="everysoft-scheduler-eventform"></div>
</div>
<script>
    window.everysoft['eventForm'] = $("#everysoft-scheduler-eventform").dxForm(
        {
            colCount: 2,
            items:
            [
                {
                    dataField: 'text',
                },
                {
                    dataField: 'scheduler_ids',
                    editorType: 'dxTagBox',
                    editorOptions:
                        {
                            dataSource: '{!! route('everysoft.scheduler.schedulers.json') !!}',
                        },
                },
                {
                    dataField: 'category',
                    colSpan: 2,
                },
                {
                    dataField: 'start_date',
                    editorType: 'dxDateBox',
                    editorOptions:
                        {
                            type: 'datetime',
                        },
                },
                {
                    dataField: 'end_date',
                    editorType: 'dxDateBox',
                    editorOptions:
                        {
                            type: 'datetime',
                        },
                },
                {
                    dataField: 'firstPeriod',
                },
                {
                    dataField: 'lastPeriod',
                },
                {
                    dataField: 'description',
                    colSpan: 2,
                    editorType: 'dxHtmlEditor',
                    editorOptions:
                        {
                            height: 200,
                            toolbar: {
                                items: [
                                    'undo', 'redo', 'separator',
                                    {
                                        name: 'size',
                                        acceptedValues: ['8pt', '10pt', '12pt', '14pt', '18pt', '24pt', '36pt'],
                                    },
                                    {
                                        name: 'font',
                                        acceptedValues: ['Arial', 'Courier New', 'Georgia', 'Impact', 'Lucida Console', 'Tahoma', 'Times New Roman', 'Verdana'],
                                    },
                                    'separator',
                                    'bold', 'italic', 'strike', 'underline', 'separator',
                                    'alignLeft', 'alignCenter', 'alignRight', 'alignJustify', 'separator',
                                    'color', 'background',
                                ],
                            },
                        },
                },
            ]
        }).dxForm('instance');

    window.everysoft['eventFormPopup'] = $("#everysoft-scheduler-eventformpopup").dxPopup(
        {
            width: 800,
            height: 600,
            showCloseButton: true,
            title: "Create event",
            contentTemplate: window.everysoft['eventForm'].element()
        }).dxPopup('instance');
</script>