<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeadEnterp extends Model
{
    protected $table = 'head_enterptises';

    protected $fillable = [
        'id', 'full_name_head', 'id_position'
    ];

    public function position(){
        return $this->belongsTo('App\Position', 'id_position', 'id');
    }

    public function directors(){
        return $this->hasMany('App\Director', 'id_head', 'id');
    }

}
