<?php

namespace App\Http\Resources;

use App\Donation;
use App\Report;
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
        // $test = Report::with(['donates']);
        // dd($test);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'location' => $this->location,
            'target_dontaion' => $this->target_donation,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'user' => new UserResource($this->whenLoaded('users')),
            'community' => new CommunityResource($this->whenLoaded('communities')),
            'pic_name' => $this->pic_name,
            'docs' => $this->docs,
            'total_donate' => Donation::where('report_id','=',$this->id)->get()->sum('amount'),
            'image' => $this->images,
            // 'total' => $this->whenPivotLoadedAs('report_id','donates', function(){
            //     return sum($this->donates->amount);
            // }),
            'created_at' => $this->created_at
        ];
    }
}
