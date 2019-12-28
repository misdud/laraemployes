<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employe extends Model
{
    protected $table = 'employees';

    public $timestamps = false;

    protected $fillable = [
        'id', 'full_name', 'employment', 'ratio', 'id_departament', 'id_positione'
    ];


    public function position(){
        return $this->belongsTo('App\Position', 'id_positione', 'id');
    }

    public function department(){
        return $this->belongsTo('App\Deputy', 'id_departament', 'id');
    }

}
