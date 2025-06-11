<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'group_id' => $this->group_id,
            'course_id' => $this->course_id,
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'group' => GroupResource::make($this->whenLoaded('group')),
            'course' => CourseResource::make($this->whenLoaded('course')),
        ];
    }
}
