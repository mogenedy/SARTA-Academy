<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    
    /**
     * 
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $translations = null;

        if($request->is('api/course/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'title' => $translations['title'] ?? $this->title,
            'description' => $translations['description'] ?? $this->description,
            'price' => $this->price,
            'online' => $this->online,
            'live' => $this->live,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'duration' => $this->duration,
            'level' => $this->level,
            'category_id' => $this->category_id,
            'institute_id' => $this->institute_id,
            'main_group' => $this->when($request->is('api/course/*') && $request->isMethod("GET"), function () { 
                return $this->whenLoaded('main_group' , GroupResource::make($this->main_group));
            }),
            'certification' => $this->when($request->is('api/course/*') && $request->isMethod("GET"), function () use($translations) { 
                return $translations['certification'] ?? $this->certification;
            }),
            'curriculam' => $this->when($request->is('api/course/*') && $request->isMethod("GET"), function () use($translations) { 
                return $translations['curriculam'] ?? $this->curriculam;
            }),
            'what_will_you_learn' => $this->when($request->is('api/course/*') && $request->isMethod("GET"), function () use($translations) { 
                return $translations['what_will_you_learn'] ?? $this->what_will_you_learn;
            }),
            'image' => MediaResource::make($this->getMedia("main")->first()),
            'users' => $this->when($request->isMethod("GET"), function () { 
                return $this->whenLoaded('users' , UserResource::collection($this->users))->response()->getData();
            }),
            'category' => $this->when($request->isMethod("GET"), function () { 
                return $this->whenLoaded('category' , CategoryResource::make($this->category));
            }),
            'institute' => $this->when($request->isMethod("GET"), function () { 
                return $this->whenLoaded('institute' , $this->institute);
            }),
            'lessons' => $this->when($request->is('api/course/*') && $request->isMethod("GET"), function () { 
                return $this->whenLoaded('lessons' , LessonResource::collection($this->lessons))->response()->getData();
            }),
        ];
    }
}
