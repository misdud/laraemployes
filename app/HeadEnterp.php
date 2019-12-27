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
        return $this->hasMany('App\Position', 'id_position', 'id');
    }


}
