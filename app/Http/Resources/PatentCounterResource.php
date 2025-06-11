<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatentCounterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'issued' => (int) $this->issued,
            'pending' => (int) $this->pending,
            'total' => (int) $this->issued + $this->pending,
        ];
    }
}
