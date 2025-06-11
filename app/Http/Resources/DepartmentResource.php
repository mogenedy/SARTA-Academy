<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
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
            'title' => $translations['title'] ?? $this->title,
            'description' => $translations['description'] ?? $this->description,
            'vision' => $translations['vision'] ?? $this->vision,
            'mission' => $translations['mission'] ?? $this->mission,
            'institute_id' => $this->institute_id,
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'researchers' =>  $this->when(isset($this->researchers) , UserResource::collection($this->researchers)->response()->getData()) ,
       ];
    }
}
