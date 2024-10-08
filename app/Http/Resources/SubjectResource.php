<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Subject */
class SubjectResource extends JsonResource
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
            'slug' => $this->title,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'courses_count' => $this->when($this->courses_count, $this->courses_count),
            'exams_count' => $this->when($this->exams_count, $this->exams_count),
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'exams' => CourseResource::collection($this->whenLoaded('exams')),
        ];
    }
}
