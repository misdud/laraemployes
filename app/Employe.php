<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Employe
 *
 * @property int $id
 * @property string|null $full_name
 * @property string|null $employment
 * @property float|null $ratio
 * @property int $id_departament
 * @property int $id_positione
 * @property-read \App\Deputy $department
 * @property-read \App\Position $position
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe whereEmployment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe whereIdDepartament($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe whereIdPositione($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Employe whereRatio($value)
 * @mixin \Eloquent
 */
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
        return $this->belongsTo('App\Department', 'id_departament', 'id');
    }


}
