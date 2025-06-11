<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        if($request->is('api/user/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        $data = [
            'id' => $this->id,
            'name' => $translations['name'] ?? $this->name,
            'email' => $this->email,
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'ban' => $this->ban,
            'role' => $this->getRoleNames()[0],
            'phone' => $this->phone,
            'token' => $this->when($this->token, $this->token),
        ];

        if ($this->getRoleNames()[0] == "researcher" && $this->whenLoaded('researcher_profile')) {
            $data['researcher_profile'] = ReesearcherProfileResource::make($this->whenLoaded('researcher_profile'));
        }

        return $data;
    }
}
