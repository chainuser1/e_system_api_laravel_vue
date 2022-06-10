<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Personnel;
use Faker\Generator as Faker;

$factory->define(Personnel::class, function (Faker $faker) {
    return [
        //
        "employee_number" => $faker->unique()->numberBetween(1000000, 9999999),
        "first_name" => $faker->firstName,
        "last_name" => $faker->lastName,
        "middle_name" => $faker->optional()->firstName,
        "suffix" => $faker->optional()->randomElement(['Jr.', 'Sr.', 'II', 'III']),
        "type" => $faker->randomElement(['instructor', 'staff','admin']),
    ];
});
