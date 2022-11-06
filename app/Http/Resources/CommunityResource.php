<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommunityResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected $fillable = ['name','email','password','stamp','is_verified'];
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'stamp' => $this->stamp,
            'is_verified' => $this->is_verified,
            'created_at' => $this->created_at
        ];
    }
}
