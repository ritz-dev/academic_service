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
            'title' => $this->title,
            'date' => $this->date,
            'startTime' => $this->start_time,
            'endTime' => $this->end_time,
            'isHoliday' => $this->is_holiday,
            'section' => [
                'id' => $this->section->id,
                'name' => $this->section->name,
                'academicClassName' => $this->section->academicClass->name,
            ],
            'subject' => [
                'id' => $this->subject != null ? $this->subject->id : null,
                'name' => $this->subject != null ? $this->subject->name : null,
                'code' => $this->subject != null ? $this->subject->code : null,
                'description' => $this->subject != null ? $this->subject->description : null,
            ],
            'teacher' => $this->teacher_id,
        ];
    }
}
