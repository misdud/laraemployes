<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //protected $table = 'positions';

    protected $fillable = [
        'id', 'name_position', 'salary_position'
    ];

    public function headEnters(){
        return $this->hasMany('App\HeadEnterp', 'id_position', 'id');
    }

    public function directors(){
        return $this->hasMany('App\Director', 'id_positiond', 'id');
    }


}
