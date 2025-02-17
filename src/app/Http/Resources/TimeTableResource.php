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
            'day' => $this->day,
            'startTime' => $this->start_time,
            'endTime' => $this->end_time,
            'type' => $this->type,
            'section' => [
                'id' => $this->section->id,
                'name' => $this->section->name,
                'academicClassName' => $this->section->academicClass->name,
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
