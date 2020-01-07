<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Department::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'name' => $faker->bothify('Отдел ##?'),
        'id_deputys'=>$faker->numberBetween($min = 1, $max = 30),
        'name_head_depart'=>$faker->name,
        'id_posit_head'=>9

    ];
});
