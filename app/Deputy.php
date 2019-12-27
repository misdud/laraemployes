<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deputy extends Model
{
    //
    protected $table = 'deputys';

    public $timestamps = false;

    protected $fillable = [
        'id', 'full_name_deputy', 'id_positionde', 'id_director'
    ];

    public function director(){
        return $this->belongsTo('App\Director', 'id_director', 'id');
    }

    public function positions(){
        return $this->hasMany('App\Position', 'id_positionde', 'id');
    }


}
