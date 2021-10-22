<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'phone' => $this->phone,
            'email' => $this->email,
            'balance' => $this->balance,
            // 'club' => $this->club_id,
            'is_active'=>$this->is_active,
            'joinded_at' => $this->created_at->toDateTimeString(),
            'roles' => $this->getRoleNames(),
        ];
    }
}
