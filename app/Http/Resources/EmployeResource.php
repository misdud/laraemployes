<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
Use App\Employe;

class EmployeResource extends JsonResource
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
            'name'=>$this->full_name,
            'employment'=>date('d.m.Y',strtotime($this->employment)),
            'ratio'=>$this->ratio,
            'salary_position'=>$this->position->salary_position,
            'position'=>$this->position->name_position,
            'name_head_depart'=>$this->department->name_head_depart

        ];

        //return parent::toArray($request);
    }
}
