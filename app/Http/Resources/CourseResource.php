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
            'slug' => $this->slug,
            'description' => $this->desdescription,
            'requirements' => $this->desdescription,
            'price' => $this->price,
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
            'examSessions' => ExamSessionResource::collection($this->whenLoaded('examSessions')),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'exams' => ExamResource::collection($this->whenLoaded('exams')),
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'lessons_count' => $this->whenCounted('lessons'),
            'students_count' => $this->whenCounted('students'),
            'exam_sessions_count' => $this->whenCounted('examSessions'),
            'exams_count' => $this->whenCounted('exams'),
        ];
    }
}
