<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'profile'    => $this->whenLoaded('profile', function () {
                return $this->profile ? new UserProfileResource($this->profile) : null;
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
