<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Deputy::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'full_name_deputy' => $faker->name,
        'id_positionde'=>$faker->numberBetween($min = 3, $max = 8),
        'id_director'=>$faker->numberBetween($min = 1, $max = 6),
    ];
});
