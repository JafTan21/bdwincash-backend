<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KingsResource extends JsonResource
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
            'username' => $this->user->username,
            'amount' => $this->amount,
            'rate' => $this->rate,
            'possible_return' => $this->amount * $this->rate,
            'status' => ($this->status ? 'Win' : 'lost'),
            'on' => $this->option,
            'date' => $this->created_at->toDateTimeString(),
        ];
    }
}
