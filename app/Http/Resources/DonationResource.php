<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationResource extends JsonResource
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
            'user' => new UserResource($this->users),
            'report' => new ReportResource($this->reports),
            'amount' => $this->amount,
            'created_at' => $this->created_at
        ];
    }
}
