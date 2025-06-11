<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/event/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'description' => $translations['description'] ?? $this->description,
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'what_will_you_learn' => $translations['what_will_you_learn'] ?? $this->what_will_you_learn,
            'date' => $this->date,
            'phone' => $this->phone,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'blogs' => BlogResource::collection($this->whenLoaded('blogs')),
        ];
    }
}
