<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeadDepartament extends Model
{
    protected $table = 'head_departaments';

    public $timestamps = false;

    protected $fillable = [
        'id',  'id_departamentd', 'id_employee'
    ];


    public function departament(){
        return $this->belongsTo('App\Department', 'id_departamentd', 'id');
    }

    public function employe(){
        return $this->belongsTo('App\Employe', 'id_employee', 'id');
    }
}
