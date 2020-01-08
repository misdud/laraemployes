<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Employe::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'full_name'=>$faker->name,
        'employment'=>$faker->dateTimeBetween($startDate = '-40 years', $endDate = 'now', $timezone = null),
        'ratio'=>$faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 1.5),
        'id_departament'=>$faker->numberBetween($min = 1, $max = 200),
        // for test
        // 9 - for headDepart
        //'id_positione'=> 9
        'id_positione'=>$faker->numberBetween($min = 10, $max = 22),
    ];
});
