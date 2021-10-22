<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawResource extends JsonResource
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
            'method' => $this->method,
            'number' => $this->number,
            'amount' => $this->amount,
            'date' => $this->created_at->toDateTimeString(),
            'statusText' => $this->getStatusText(),
            'status' => $this->status,
        ];
    }

    public function getStatusText()
    {
        if ($this->status == 0) {
            return 'Rejected';
        }
        if ($this->status == 1) {
            return 'Approved';
        }

        return 'Pending'; //2
    }
}
