<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HeadDepartament
 *
 * @property int $id
 * @property int $id_departamentd
 * @property int $id_employee
 * @property-read \App\Department $departament
 * @property-read \App\Employe $employe
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadDepartament newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadDepartament newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadDepartament query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadDepartament whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadDepartament whereIdDepartamentd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadDepartament whereIdEmployee($value)
 * @mixin \Eloquent
 */
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
