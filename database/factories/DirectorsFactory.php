<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Director::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('ru_RU');
    return [
        'full_name_director' => $faker->name,
        'id_positiond'=>2,
        'id_head'=>1
    ];
});
