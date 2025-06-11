<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectorMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

       return [
        'id' => $this->id,
        'title' => $translations['title'] ?? $this->title,
        'description' => $translations['description'] ?? $this->description,
        'image' => MediaResource::make($this->getMedia("main")->first()),
       ];
    }
}
