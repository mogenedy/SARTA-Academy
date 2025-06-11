<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReesearcherProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'biography' => $this->biography,
            'year_of_experience' => $this->year_of_experience,
            'show_email' => $this->show_email,
            'show_phone' => $this->show_phone,
            'education_qualification' => $this->education_qualification,
            'user_id' => $this->user_id,
            'attachment' => MediaResource::make($this->getMedia("main")->first()),
            'linked_in' => $this->linked_in
        ];
    }
}
