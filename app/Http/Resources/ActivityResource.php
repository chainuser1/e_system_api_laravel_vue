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
            'title' => $this->title,
            'description' => $this->description,
            'file_url' => $this->file_url,
            'created_at'=> $this->created_at,
            'subject' => $this->subject_id,
            'instructor' => $this->instructor_id,
        ];
    }
}
