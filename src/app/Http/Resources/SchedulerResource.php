<?php

namespace everysoft\dxScheduler\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchedulerResource extends JsonResource
{
    public function toArray ($request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'label' => $this->label,
            'description' => $this->description,
            'text_color' => $this->text_color,
            'background_color' => $this->background_color,
            'user_id' => $this->user_id,
            'data' => $this->data,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}