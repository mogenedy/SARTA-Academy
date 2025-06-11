<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/patent/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'patent_number' => $this->patent_number,
            'patent_date' => $this->patent_date,
            'description' => $translations['description'] ?? $this->description,
            'researchers' => UserResource::collection($this->whenLoaded('researchers')),
        ];
    }
}
