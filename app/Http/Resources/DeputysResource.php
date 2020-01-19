<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeputysResource extends JsonResource
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
            'name'=>$this->full_name_deputy,
            'position'=>$this->position->name_position,
            'director'=>$this->director->full_name_director,
        ];
        //return parent::toArray($request);
    }
}
