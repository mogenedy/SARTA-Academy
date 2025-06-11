<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrizeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/prize/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

       return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'year' => $this->year,
            'researcher_name' => $translations['researcher_name'] ??$this->researcher_name,
            'researcher' => UserResource::make($this->whenLoaded('researcher')),
        ];
    }
}
