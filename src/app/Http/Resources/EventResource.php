<?php

namespace everysoft\scheduler\app\Http\Resources;

use App\Models\EDT;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class EventResource extends JsonResource
{
    public function toArray ($request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'description' => nl2br($this->description),
            'startDate' => $this->start_date->toISO8601String(),
            'endDate' => $this->end_date->toISO8601String(),
            'allDay' => $this->all_day,
            'recurrenceRule' => $this->recurrence_rule,
            'recurrenceException' => $this->recurrence_exception,
            'scheduler_id' => $this->scheduler_id,
            'scheduler_ids' => $this->scheduler_ids,
            'scheduler_reference' => $this->scheduler->reference,
            'scheduler_name' => $this->scheduler->label,
            'background_color'=> $this->scheduler->background_color,
            'text_color' => $this->scheduler->text_color,
            'category_id' => $this->category_id,
            'category_label' => $this->category?->label,
            'category_text_color' => $this->category?->text_color,
            'category_background_color' => $this->category?->background_color,
            'form' => $this->form,
            'binding' => $this->binding,
        ];
    }
}
