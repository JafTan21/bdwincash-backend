<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'=>$this->id,
            'to'=>($this->user) ? $this->user->username : 'Everyone',
            'subject'=>$this->subject,
            'message'=>$this->message,
            'date'=>$this->created_at->toDateTimeString(),
        ];
    }
}
