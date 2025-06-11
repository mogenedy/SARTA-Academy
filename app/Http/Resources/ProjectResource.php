<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/project/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

       return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'finance' => $translations['finance'] ?? $this->finance,
            'duration' => $translations['duration'] ?? $this->duration,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'description' => $translations['description'] ?? $this->description,
            'objectives' => $translations['objectives'] ?? $this->objectives,
            'deliverables' => $translations['deliverables'] ?? $this->deliverables,
            'beneficaries' => $translations['beneficaries'] ?? $this->beneficaries,
            'department_name' => $this->whenLoaded('department' , $this->department->title),
            'researchers' => UserResource::collection($this->whenLoaded('researchers')),
            'image' => MediaResource::make($this->getMedia("main")->first()),
        ];
    }
}
