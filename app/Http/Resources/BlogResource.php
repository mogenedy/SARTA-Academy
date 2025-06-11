<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/blog/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'slug' => $translations['slug'] ?? $this->slug,
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'description' => $translations['description'] ?? $this->description,
            'category' => BlogCategoryResource::make($this->whenLoaded('blog_category')),
            'tags' => BlogTagResource::collection($this->whenLoaded('tags')),
            'events' => EventResource::collection($this->whenLoaded('events')),
        ];
    }
}
