<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\File */
class FileResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'path' => $this->path,
            'file_name' => $this->file_name,
            'extension' => $this->extension,
            'mime' => $this->mime,
            'type' => $this->type,
            'public_path' => $this->public_path,
            'parent_id' => $this->parent_id,
            'uploaded_by' => $this->uploaded_by,
        ];
    }
}
