<?php

namespace App\Http\Resources;

use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Resources\ExamResource;
use App\Http\Resources\LessonResource;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Section */
class SectionResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'exams' => ExamResource::collection($this->whenLoaded('exams')),
            'resources' => $this->transform($this->resources, function($resources){
                return $resources->map(function($resource) {
                    if (is_a($resource, Lesson::class)) {
                        return new LessonResource($resource);
                    } else {
                        return new ExamResource($resource);
                    }
                });
            })
        ];
    }
}
