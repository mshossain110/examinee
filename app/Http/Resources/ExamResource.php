<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'description' => $this->description,
            'permalink' => $this->permalink,
            'status' => $this->status,
            'duration' => $this->duration,
            'pass_mark' => $this->pass_mark,
            'meta' => $this->meta,
            'number_of_questions' => $this->number_of_questions,
            'random_questions' => $this->random_questions,
            'certification' => $this->certification,
            'difficulty' => $this->difficulty,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            'examiner' => new UserResource($this->whenLoaded('examiner')),
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
            'results' => ResultResource::collection($this->whenLoaded('results')),
        ];
    }
}
