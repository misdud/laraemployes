<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartResource extends JsonResource
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
            'nameOtdel'=>$this->name,
            'name'=>$this->name_head_depart,
            'position'=>$this->position->name_position,
            'deputy'=>$this->deputy->full_name_deputy,
        ];
        // return parent::toArray($request);
    }
}
