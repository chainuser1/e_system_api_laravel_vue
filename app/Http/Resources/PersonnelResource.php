<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonnelResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'middle_name' => $this->middle_name,
            'suffix' => $this->suffix,
            'type' => $this->type,
            'employee_number' => $this->employee_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user'=> new UserResource::collection(User::where('membership_number','employee_number')->first())
        ];
    }
}
