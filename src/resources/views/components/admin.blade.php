<div id="everysoft-scheduler-categories"></div>
<script>
    $("#everysoft-scheduler-categories").dxDataGrid({
        dataSource: {!! json_encode(\everysoft\scheduler\app\Models\Category::all()); !!},

    });
</script>