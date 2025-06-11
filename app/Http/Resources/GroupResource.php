<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if($request->is('api/group/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'name' => $translations['name'] ?? $this->name,
            'group_link' => url('/') . "/api/private_group/" . $this->uuid,
            'registration_link' => url('/') . "/api/groupRegistration/" . $this->uuid,
            'is_main' => $this->is_main,
            'live' => $this->live,
            'max_users' => $this->max_users,
            'expires_at' => $this->expires_at,
            'course_id' =>  $this->course_id,
        ];
    }
}
