<style>
    .main-box {
        display: flex;
        flex-direction: row;
        width: 100%;
        height: 100%;
        justify-content: flex-start;
        align-items: stretch;
    }

    .row1 {
        display: flex;
        max-width: none;
        min-width: 0px;
        flex: 1 1 0px;
    }

    .row4 {
        display: flex;
        max-width: none;
        min-width: 0px;
        flex: 4 1 0px;
    }
</style>
<div class="dx-box-flex dx-box dx-widget dx-collection main-box">
    <div class="dx-item dx-box-item row1">
        <livewire:everysoft-dxScheduler-navigation
                :key="'everysoft-dxScheduler-navigation-'.$ref"
                :allows="$allows"
                :schedulersRouteName="$schedulersRouteName"
                :eventsUpdateRouteName="$eventsUpdateRouteName"
                :createButton="$createButton"
        ></livewire:everysoft-dxScheduler-navigation>
    </div>
    <div class="dx-item dx-box-item row4">
        <livewire:everysoft-dxScheduler-calendar
                :key="'everysoft-dxScheduler-calendar-'.$ref"
                :currentView="$currentView"
                :allows="$allows"
                :schedulersRouteName="$schedulersRouteName"
                :eventsRouteName="$eventsRouteName"
                :eventsUpdateRouteName="$eventsUpdateRouteName"
                :eventsDeleteRouteName="$eventsDeleteRouteName"
                :eventMenuItem="$eventMenuItem"
                :cellMenuItem="$cellMenuItem"
        ></livewire:everysoft-dxScheduler-calendar>
    </div>
</div>
