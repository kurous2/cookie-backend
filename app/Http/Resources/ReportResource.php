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
    protected $fillable = ['title','category','location','target_donation','due_date', 'status'];
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
            'created_at' => $this->created_at
        ];
    }
}
