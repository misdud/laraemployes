<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeadEnterpResource extends JsonResource
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
            'name'=>$this->full_name_head,
            'position'=>$this->position->name_position,
        ];
        //return parent::toArray($request);
    }
}
