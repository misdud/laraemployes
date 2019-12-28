<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'id_deputys'
    ];

    public function deputy(){
        return $this->belongsTo('App\Deputy', 'id_deputys', 'id');
    }

    public function employes(){
        return $this->hasMany('App\Employe', 'id_departament', 'id');
    }

    public function headDepartament(){
        return $this->belongsTo('App\Department', 'id_departamentd', 'id');
    }

}
