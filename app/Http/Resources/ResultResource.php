<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
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
            'answers' => $this->answers,
            'obtain_mark' => $this->obtain_mark,
            'is_pass' => $this->is_pass,
            'time_taken' => $this->time_taken,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'examinee' => new UserResource($this->whenLoaded('examinee')),
            'exam' => new ExamResource($this->whenLoaded('exam')),
        ];
    }
}
