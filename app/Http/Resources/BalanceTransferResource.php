<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceTransferResource extends JsonResource
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
            'from'=>$this->from,
            'to'=>$this->to,
            'amount'=>$this->amount,
            'date'=>$this->created_at->toDateTimeString()
        ];
    }
}
