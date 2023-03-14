<div id="everysoft-scheduler-eventformpopup">
    <div id="everysoft-scheduler-eventform"></div>
</div>
<script>
    if(!window.everysoft) window.everysoft=[];
    window.everysoft['periods'] = {!! json_encode(\App\Models\Period::all()); !!};
    window.everysoft.displayPeriodStart = (value) =>
    {
        if (value !== null)
        {
            const start = new Date(value.start).toLocaleTimeString("fr-fr", {
                hour: '2-digit',
                minute: '2-digit'
            });
            const label = value.label + " => " + start;
            return label;
        }
    };
    window.everysoft.displayPeriodEnd = (value) =>
    {
        if (value !== null)
        {
            const end = new Date(value.end).toLocaleTimeString("fr-fr", {
                hour: '2-digit',
                minute: '2-digit'
            });
            const label = value.label + " => " + end;
            return label;
        }
    };

    window.everysoft['eventForm'] = $("#everysoft-scheduler-eventform").dxForm(
        {
            // labelMode: "floating",
            // formData: {},
            colCount: 2,
            colCountByScreen: 2,
            items:
            [
                {
                    itemType: 'group',
                    colSpan: 2,
                    colCount: 2,
                    items:
                    [
                        {
                            dataField: 'text',
                            label: { text: '@lang('Title')', },
                            isRequired: true,
                            colSpan: 2,
                        },
                        {
                            dataField: 'category',
                            label: { text: '@lang('Category')', },
                            isRequired: true,
                            editorType: 'dxSelectBox',
                            editorOptions:
                                {
                                    dataSource: {!! json_encode(\everysoft\scheduler\app\Models\Category::all()) !!},
                                    displayExpr: 'label',
                                    valueExpr: 'id',
                                },
                        },
                        {
                            dataField: 'scheduler_ids',
                            label: { text: '@lang('Schedulers')', },
                            isRequired: true,
                            editorType: 'dxTagBox',
                            editorOptions:
                                {
                                    dataSource: '{!! route('schedulers.dashboard') !!}',
                                    showSelectionControls: true,
                                    applyValueMode: 'useButtons',
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
                                        label: { text: '@lang('Period')', },
                                        editorType: 'dxSelectBox',
                                        editorOptions:
                                            {
                                                dataSource: window.everysoft['periods'],
                                                showClearButton: true,
                                                displayExpr: window.everysoft.displayPeriodStart,
                                                onValueChanged: (options) =>
                                                {
                                                    if(options.value === null) return;

                                                    const startEditor = window.everysoft['eventForm'].getEditor('start_date');
                                                    let date = startEditor.option('value');
                                                    let period = new Date(options.value.start);
                                                    let newdate = new Date(date.setHours(period.getHours(), period.getMinutes(), period.getSeconds()));
                                                    startEditor.option('value', newdate);
                                                    startEditor.repaint();

                                                    const endPeriodEditor = window.everysoft['eventForm'].getEditor('lastPeriod');
                                                    const startPeriodEditor = window.everysoft['eventForm'].getEditor('firstPeriod');
                                                    const endPeriod = endPeriodEditor.option('value');
                                                    const startPeriod = startPeriodEditor.option('value');
                                                    if((endPeriod === null) || (endPeriod.id < startPeriod.id))
                                                    {
                                                        endPeriodEditor.option('value', startPeriod);
                                                    }
                                                },
                                            },
                                    },
                                    {
                                        dataField: 'start_date',
                                        label: { text: '@lang('Date')', },
                                        isRequired: true,
                                        editorType: 'dxDateBox',
                                        editorOptions:
                                            {
                                                type: 'datetime',
                                                value: new Date(),
                                            },
                                    },
                                ]
                        },
                        {
                            itemType: "group",
                            caption: "End",
                            colCount: 3,
                            items:
                                [
                                    {
                                        dataField: 'lastPeriod',
                                        label: { text: '@lang('Period')', },
                                        editorType: 'dxSelectBox',
                                        editorOptions:
                                            {
                                                dataSource: window.everysoft['periods'],
                                                showClearButton: true,
                                                displayExpr: window.everysoft.displayPeriodEnd,
                                                onValueChanged: (options) =>
                                                {
                                                    if(options.value === null) return;

                                                    let date = window.everysoft['eventForm'].getEditor('end_date').option('value');
                                                    let period = new Date(options.value.end);
                                                    let newdate = new Date(date.setHours(period.getHours(), period.getMinutes(), period.getSeconds()));
                                                    window.everysoft['eventForm'].getEditor('end_date').option('value', newdate);
                                                    window.everysoft['eventForm'].getEditor('end_date').repaint();

                                                    const endPeriodEditor = window.everysoft['eventForm'].getEditor('lastPeriod');
                                                    const startPeriodEditor = window.everysoft['eventForm'].getEditor('firstPeriod');
                                                    const endPeriod = endPeriodEditor.option('value');
                                                    const startPeriod = startPeriodEditor.option('value');
                                                    if((startPeriod === null) || (startPeriod.id > endPeriod.id))
                                                    {
                                                        startPeriodEditor.option('value', endPeriod);
                                                    }
                                                },
                                            },
                                    },
                                    {
                                        dataField: 'end_date',
                                        colSpan: 2,
                                        label: { text: '@lang('Date')', },
                                        isRequired: true,
                                        editorType: 'dxDateBox',
                                        editorOptions:
                                            {
                                                type: 'datetime',
                                                value: new Date(),
                                            },
                                    },
                                ]
                        },
                        {
                            itemType: 'group',
                            colSpan: 2,
                            colCount: 3,
                            items:
                            [
                                {
                                    dataField: 'allDay',
                                    label: { text: '@lang('All day')', location: 'left', },
                                    editorType: 'dxSwitch',
                                    editorOptions:
                                        {
                                            onValueChanged: (options) =>
                                                {
                                                    const type = options.value?'date':'datetime';
                                                    window.everysoft['eventForm'].getEditor('start_date').option('type', type);
                                                    window.everysoft['eventForm'].getEditor('end_date').option('type', type);
                                                },
                                        },
                                },
                                {
                                    dataField: 'repeat',
                                    label: { visible: false,},
                                    editorType: 'dxSelectBox',
                                    editorOptions:
                                        {
                                            dataSource: ['No repeat', 'Repeat weekly', 'Repeat montly'],
                                            value: 'No repeat',
                                            onValueChanged: (options) =>
                                            {
                                                const value = (options.value === 'No repeat');
                                                window.everysoft['eventForm'].getEditor('until').option('disabled', value);
                                                window.everysoft['eventForm'].itemOption('until', 'isRequired', !value);
                                            },
                                        },
                                },
                                {
                                    dataField: 'until',
                                    label: { text: '@lang('Repeat until')', location: 'left',},
                                    editorType: 'dxDateBox',
                                    editorOptions:
                                        {
                                            disabled: true,
                                            type: 'date',
                                            showClearButton: true,
                                        },
                                },
                            ],
                        },
                        {
                            dataField: 'description',
                            label: { text: '@lang('Description')', },
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
            height: 700,
            showCloseButton: true,
            title: '@lang('Create event')',
            contentTemplate: function() { return window.everysoft['eventForm'].element(); },
            toolbarItems:
            [
                {
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options:
                        {
                            icon: 'save',
                            text: 'Save',
                            onClick()
                            {

                            },
                        },
                },
                {
                    widget: 'dxButton',
                    toolbar: 'bottom',
                    location: 'after',
                    options:
                        {
                            icon: 'close',
                            text: 'Close',
                            onClick()
                            {
                                window.everysoft['eventFormPopup'].hide();
                            },
                        },
                },
            ],
        }).dxPopup('instance');
</script>
