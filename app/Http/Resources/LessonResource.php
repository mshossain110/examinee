<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'type' => $this->type,
            'object' => $this->object,
            'short_text' => $this->short_text,
            'full_text' => $this->full_text,
            'position' => $this->position,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'students' => UserResource::collection($this->whenLoaded('students')),
            'examSessions' => ExamSessionResource::collection($this->whenLoaded('examSessions')),
        ];
    }
}
