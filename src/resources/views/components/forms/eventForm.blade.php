<div id="everysoft-scheduler-eventformpopup">
    <div id="everysoft-scheduler-eventform"></div>
</div>
<script>
    function editPopupEventForm()
    {
        window.everysoft['eventFormPopup'].show();
    }

    if(!window.everysoft) window.everysoft=[];
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
                                        dataField: 'start_date',
                                        label: { text: '@lang('Start')', },
                                        isRequired: true,
                                        editorType: 'dxDateBox',
                                        editorOptions:
                                            {
                                                type: 'datetime',
                                                value: new Date(),
                                            },
                                    },


                                    {
                                        dataField: 'end_date',
                                        colSpan: 2,
                                        label: { text: '@lang('End')', },
                                        isRequired: true,
                                        editorType: 'dxDateBox',
                                        editorOptions:
                                            {
                                                type: 'datetime',
                                                value: new Date(),
                                            },
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
                                {{--$.ajax({--}}
                                {{--    url: '{{ route('evaluations.store') }}',--}}
                                {{--    method: 'post',--}}
                                {{--    data: window.everysoft['eventForm'].option('formdata'),--}}
                                {{--}).done(function (html)--}}
                                {{--{--}}
                                {{--    console.log(html);--}}
                                {{--    window.everysoft['eventFormPopup'].hide();--}}
                                {{--});--}}
                            }
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
