<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/gallery/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

       return [
        'id' => $this->id,
        'title' => $translations['title'] ?? $this->title,
        'link' => $this->link,
        'file' => MediaResource::make($this->getMedia("main")->first()),
       ];
    }
}
