<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource
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
            'from_method' => $this->from_method,
            'from_number' => $this->from_number,
            'to_method' => $this->to_method,
            'to_number' => $this->to_number,
            'amount' => $this->amount,
            'transaction_number' => $this->transaction_number,
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
