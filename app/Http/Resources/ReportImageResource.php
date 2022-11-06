<?php

namespace App\Http\Resources;

use App\Report;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportImageResource extends JsonResource
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
            'report' => new ReportResource($this->report),
            'image' => $this->amount,
            'created_at' => $this->created_at
        ];
    }
}
