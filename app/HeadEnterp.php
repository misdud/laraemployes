<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HeadEnterp
 *
 * @property int $id
 * @property string|null $full_name_head
 * @property int $id_position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Director[] $directors
 * @property-read int|null $directors_count
 * @property-read \App\Position $position
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadEnterp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadEnterp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadEnterp query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadEnterp whereFullNameHead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadEnterp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HeadEnterp whereIdPosition($value)
 * @mixin \Eloquent
 */
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
