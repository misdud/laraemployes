<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Position
 *
 * @property int $id
 * @property string|null $name_position
 * @property int|null $salary_position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Director[] $directors
 * @property-read int|null $directors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\HeadEnterp[] $headEnters
 * @property-read int|null $head_enters_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereNamePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Position whereSalaryPosition($value)
 * @mixin \Eloquent
 */
class Position extends Model
{
    //protected $table = 'positions';

    protected $fillable = [
        'id', 'name_position', 'salary_position'
    ];

    public function headEnters(){
        return $this->hasMany('App\HeadEnterp', 'id_position', 'id');
    }

    public function directors(){
        return $this->hasMany('App\Director', 'id_positiond', 'id');
    }

    public function employees(){
        return $this->hasMany('App\Employe', 'id_positione', 'id');
    }


}
