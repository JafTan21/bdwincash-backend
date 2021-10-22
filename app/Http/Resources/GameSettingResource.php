<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameSettingResource extends JsonResource
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
            'game_name' => $this->game_name,
            'min' => $this->min,
            'max' => $this->max,
'rate'=>$this->rate,
            'status' => $this->status,
        ];
    }
}
