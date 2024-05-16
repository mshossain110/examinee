<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'qtype' => $this->qtype,
            'question' => $this->question,
            'options' => $this->options,
            'answers' => $this->answers,
            'hint' => $this->hint,
            'mark' => $this->mark,
            'nmark' => $this->nmark,
            'explanation' => $this->explanation,
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'topics' => TopicResource::collection($this->whenLoaded('topics')),
            'exam' => new ExamResource($this->whenLoaded('exam')),
        ];
    }
}
