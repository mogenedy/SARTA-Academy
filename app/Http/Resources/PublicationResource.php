<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/publication/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'journal' => $translations['journal'] ?? $this->journal,
            'year' => $this->year,
            'researchers' => UserResource::collection($this->whenLoaded('researchers')),
        ];
    }
}
