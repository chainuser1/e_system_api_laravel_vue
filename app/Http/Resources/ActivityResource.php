<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// Use resource for Subject
use App\Http\Resources\SubjectResource;
// use resource for User
use App\Http\Resources\UserResource;
class ActivityResource extends JsonResource
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
            'title' => $this->name,
            'description' => $this->description,
            'file_url' => $this->file_url,
            'subject' => new SubjectResource($this->subject),
            'instructor' => new UserResource($this->instructor),
        ];
    }
}
