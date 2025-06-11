<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MagazineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/magazine/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

       return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'pdf' => MediaResource::make($this->getMedia("pdf")->first()),
       ];
    }
}
