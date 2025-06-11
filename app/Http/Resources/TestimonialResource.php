<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/testimonial/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'name' => $translations['name'] ?? $this->name,
            'description' => $translations['description'] ?? $this->description,
            'position' => $translations['position'] ?? $this->position,
            'image' => MediaResource::make($this->getMedia("main")->first()),
        ];
    }
}
