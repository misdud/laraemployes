<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Department
 *
 * @property int $id
 * @property string|null $name
 * @property int $id_deputys
 * @property-read \App\Deputy $deputy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employe[] $employes
 * @property-read int|null $employes_count
 * @property-read \App\Department $headDepartament
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereIdDeputys($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Department whereName($value)
 * @mixin \Eloquent
 */
class Department extends Model
{
    protected $table = 'departments';

    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'id_deputys', 'name_head_depart','id_posit_head'
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
