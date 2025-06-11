<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    
        if($request->is('api/category/*') && $request->isMethod("GET")){
            $translations = $this->getTranslations();
        }

        return [
            'id' => $this->id,
            'name' => $translations['name'] ?? $this->name,
            'courses' => $this->when($request->is('api/category/*') && $request->isMethod("GET"), function () {
                return $this->when(isset($this->courses) , CourseResource::collection($this->courses))->response()->getData();
            }),
            'numberOfCourses' => $this->when($this->courses_count , $this->courses_count)
        ];
    }
}
