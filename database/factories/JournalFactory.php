<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Journal;
use Faker\Generator as Faker;

$factory->define(Journal::class, function (Faker $faker) {
    return [
        'date' => $faker->date,
        'text' => $faker->text,

    ];
});
