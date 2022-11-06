<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'location' => $this->location,
            'target_dontaion' => $this->target_donation,
            'due_date' => $this->due_date,
            'status' => $this->status,
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'community' => new CommunityResource($this->community),
            'pic_name' => $this->pic_name,
            'docs' => $this->docs,
            'created_at' => $this->created_at
        ];
    }
}
