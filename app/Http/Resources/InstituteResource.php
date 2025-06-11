<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstituteResource extends JsonResource
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
            'name'  =>  $translations['name'] ?? $this->name,
            'vision' => $this->when($translations['vision'] || $this->vision ,  $translations['vision'] ?? $this->vision),
            'mission' =>$this->when($translations['mission'] || $this->mission , $translations['mission'] ?? $this->mission),
            'short_name' => $this->short_name,
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'about_institute' =>  AboutInstituteResource::make($this->whenLoaded('aboutInstitute')),
            'departments' =>  DepartmentResource::collection($this->whenLoaded('departments')),
            'user' =>  UserResource::make($this->whenLoaded('user')),
            'researchers' => $this->when(
                $this->relationLoaded('researchers'),
                fn() => UserResource::collection($this->researchers)->response()->getData()
            ),
        ];
    }
}
