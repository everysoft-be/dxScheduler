<div id="everysoft-scheduler-eventformpopup">
    <div id="everysoft-scheduler-eventform"></div>
</div>
<script>
    if(!window.everysoft) window.everysoft=[];
    window.everysoft['eventForm'] = $("#everysoft-scheduler-eventform").dxForm(
        {
            // labelMode: "floating",
            colCount: 3,
            items:
            [
                {
                    itemType: 'group',
                    items:
                    [
                        {
                            dataField: 'month',
                            editorType: 'dxCalendar',
                        },
                        {
                            dataField: 'scheduler_ids',
                            editorType: 'dxTagBox',
                            editorOptions:
                                {
                                    dataSource: '{!! route('everysoft.scheduler.schedulers.json') !!}',
                                },
                        },
                    ]
                },
                {
                    itemType: 'group',
                    colSpan: 2,
                    colCount: 2,
                    items:
                    [
                        {
                            dataField: 'text',
                        },
                        {
                            dataField: 'category',
                            editorType: 'dxSelectBox',
                            editorOptions:
                                {
                                    dataSource: {!! json_encode(\everysoft\scheduler\app\Models\Category::all()) !!},
                                    displayExpr: 'label',
                                    valueExpr: 'id',
                                },
                        },
                        {
                            itemType: "group",
                            caption: "Start",
                            colCount: 2,
                            items:
                                [
                                    {
                                        dataField: 'firstPeriod',
                                        label: { text: "Period", },
                                    },
                                    {
                                        dataField: 'start_date',
                                        label: { text: "Time", },
                                        editorType: 'dxDateBox',
                                        editorOptions:
                                            {
                                                type: 'time',
                                            },
                                    },
                                ]
                        },
                        {
                            itemType: "group",
                            caption: "End",
                            colCount: 2,
                            items:
                                [
                                    {
                                        dataField: 'lastPeriod',
                                        label: { text: "Period", },
                                    },
                                    {
                                        dataField: 'end_date',
                                        label: { text: "Time", },
                                        editorType: 'dxDateBox',
                                        editorOptions:
                                            {
                                                type: 'time',
                                            },
                                    },
                                ]
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