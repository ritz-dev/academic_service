<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeTableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'day_of_week' => $this->day_of_week,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'term' => $this->term,
            'class' => [
                'id' => $this->class->id,
                'name' => $this->class->name,
                'academic_year_id' => $this->class->academic_year_id,
            ],
            'subject' => [
                'id' => $this->subject->id,
                'name' => $this->subject->name,
                'code' => $this->subject->code,
                'description' => $this->subject->description,
            ],
            'teacher' => $this->teacher_id,
        ];
    }
}
