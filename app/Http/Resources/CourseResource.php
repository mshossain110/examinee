<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'subtitle' => $this->subtitle,
            'slug' => $this->slug,
            'description' => $this->description,
            'requirements' => $this->requirements,
            'price' => $this->price,
            'discount' => $this->discount,
            'status' => $this->status,
            'thumbnail' => $this->thumbnail,
            'start_date' => $this->start_date,
            'features' => $this->features,
            'permalink' => $this->permalink,
            'rating' => $this->rating,
            'certified' => $this->certified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'teachers' => UserResource::collection($this->whenLoaded('teachers')),
            'students' => UserResource::collection($this->whenLoaded('students')),
            'section' => SectionResource::collection($this->whenLoaded('section')),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'exams' => ExamResource::collection($this->whenLoaded('exams')),
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'lessons_count' => $this->whenCounted('lessons'),
            'students_count' => $this->whenCounted('students'),
            'sections_count' => $this->whenCounted('sections'),
            'exams_count' => $this->whenCounted('exams'),
        ];
    }
}
