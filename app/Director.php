<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    //protected $table = 'directors';

    public $timestamps = false;

    protected $fillable = [
        'id', 'full_name_director', 'id_positiond', 'id_head',
    ];

    public function headEnterp(){
        return $this->belongsTo('Add\HeadEnterp', 'id_head', 'id');
    }

    public function positions(){
        return $this->hasMany('App\Position', 'id_positiond', 'id');
    }

}
