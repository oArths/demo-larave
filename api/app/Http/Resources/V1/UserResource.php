<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'fistName'=> $this->fistName,
            'lastName'=> $this->lastName,
            'fullName'=> $this->fistName . ' '.$this->lastName,
            'email'=> $this->email,
        ];
    }
}
