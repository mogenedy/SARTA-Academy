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
        
        if($request->is('api/lesson/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'description' => $translations['description'] ?? $this->description,
            'link' => $this->link,
            'course_id' => $this->course_id
        ];
    }
}
