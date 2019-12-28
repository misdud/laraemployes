<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\HeadDepartament::class, function (Faker $faker) {
    static $departament = 1;
    return [
        'id_departamentd'=>$departament++,
        'id_employee'=>$faker->numberBetween($min = 1, $max = 6000),
    ];
});
