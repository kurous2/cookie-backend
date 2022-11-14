<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use Illuminate\Http\Resources\Json\ResourceCollection;

class CommunityResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'community_id' => $this->id,
            'is_verified' => $this->is_verified,
            'stamp' => $this->stamp,
            // 'user_id' => $this->user_id,
            'user_id' => $this->users->id,
            'name' => $this->users->name,
            'email' => $this->users->email,
            'role' => $this->users->role,
            'created_at' => $this->created_at
        ];
    }
}
