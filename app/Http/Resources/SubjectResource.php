<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
// use enrollment resource
use App\Http\Resources\EnrollmentResource;
// use UserResource
use App\Http\Resources\UserResource;
// use activity resource
use App\Http\Resources\ActivityResource;
class SubjectResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'instructor' => new UserResource(User::where('id',$this->instructor_id)->first()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'enrollments' => EnrollmentResource::collection($this->enrollments),
            'activities' => ActivityResource::collection($this->activities),
        ];
    }
}
