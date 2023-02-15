<?php

namespace everysoft\dxScheduler\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray ($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'description' => $this->description,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'allDay' => $this->all_day,
            'recurrenceRule' => $this->recurrence_rule,
            'recurrenceException' => $this->recurrence_exception,
            'scheduler_id' => $this->scheduler_id,
            'background_color'=> $this->scheduler->background_color,
            'text_color' => $this->scheduler->text_color,
        ];
    }
}