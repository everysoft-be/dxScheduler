<div class="everysoft-nav-vert" style="display: flex; flex-direction: column; width: 100%; height: 100%; justify-content: flex-start;
align-items: stretch;"
     wire:key="navigation">
    <style>
        .everysoft-nav-vert {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            justify-content: flex-start;
            align-items: stretch;
        }

        .everysoft-nav-vert-item {
            max-width: none;
            min-width: 0px;
        }

        .everysoft-nav-horiz {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: stretch;
        }

        .everysoft-nav-horiz-item {
            display: flex;
            max-width: none;
            min-width: 0px;
            flex-direction: row;
            justify-content: flex-end;
        }
    </style>
    <div class="everysoft-nav-vert-item">
        <div class="everysoft-nav-horiz" style="margin-bottom: 5px">
            @if($this->can('create'))
                <!-- Create button -->
                <div class="everysoft-nav-horiz-item bg-primary" style="border-radius: 15px; overflow: hidden;"
                     id="everysoft_scheduler_button_create"></div>
            @endif
            <div class="everysoft-nav-horiz-item" style="margin-left: auto">
                <!-- Tools buttons -->
                <div id="everysoft_scheduler_button_tools"></div>
            </div>
        </div>
    </div>
    <div class="everysoft-nav-vert-item">
        <!-- Categories listing -->
        <div id="everysoft_scheduler_categories"></div>
    </div>
    @include('scheduler::components.forms.eventForm')
    <script>
        $("#everysoft_scheduler_button_tools").dxButton({
            icon: "fa fa-cog",
            hint: '@lang('Settings !!! Coming soon !!!')'
        });

        $("#everysoft_scheduler_button_create").dxDropDownButton({
            text: "@lang('Create')",
            icon: "add",
            type: "normal",
            dropDownOptions:
                {
                    width: 230,
                },
            items: {!! json_encode($createButton) !!},
            displayExpr: 'label',
            keyExpr: 'label',
            onItemClick(event)
            {
                if (event.itemData.form != null)
                {
                    const method = _getMethod(event.itemData.form);
                    method(null);
                }
                else
                {
                    window.everysoft['eventFormPopup'].show();
                    //window.everysoft['scheduler'].showAppointmentPopup();
                }
            }
        });

        const menuItems = {!! json_encode($menuItems) !!};
        $("#everysoft_scheduler_categories").dxAccordion({
            dataSource: menuItems,
            animationDuration: 300,
            collapsible: true,
            multiple: true,
            selectedItems: menuItems,
            itemTitleTemplate(data)
            {
                return '<h1 style="font-weight: bold; font-size: 15px; margin:0;">' + data.label + '</H1>';
            },
            itemTemplate(data)
            {
                if (data.items.length === 0)
                {
                    return $("<div>").append('No items');
                }
                let div = $('<div>');
                data.items.forEach(function (item)
                {
                    let check = $('<div>').dxCheckBox({
                        value: true,
                        hint: item.description,
                        text: item.label,
                        onContentReady(options)
                        {
                            options.element.find('.dx-checkbox-icon').css('background-color', item.background_color);
                            options.element.find('.dx-checkbox-icon').css('color', item.text_color);
                        },
                        onValueChanged(options)
                        {
                            const reference = item.reference;
                            if (!reference)
                            {
                                if (options.value)
                                {
                                    window.everysoft['scheduler_categories'].push(item.id);
                                }
                                else
                                {
                                    window.everysoft['scheduler_categories'] = jQuery.grep(window.everysoft['scheduler_categories'], function (value)
                                    {
                                        return value != item.id;
                                    });
                                }
                            }

                            if (options.value)
                            {
                                window.everysoft['scheduler_references'].push(reference);
                            }
                            else
                            {
                                window.everysoft['scheduler_references'] = jQuery.grep(window.everysoft['scheduler_references'], function (value)
                                {
                                    return value != reference;
                                });
                            }
                            window.everysoft['scheduler'].option('dataSource', createSchedulerStore());
                        }
                    });


                    let field = $('<p>').append(check);
                    div.append(field);
                });
                return div;
            }
        });
    </script>
</div>