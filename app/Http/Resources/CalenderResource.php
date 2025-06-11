<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalenderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->is('api/calender/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'type' => $this->calenderable_type ? basename($this->calenderable_type) : "General",
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'institude_id' => $this->institude_id,
            'calenderable' => $this->calenderable
        ];
    }
}
