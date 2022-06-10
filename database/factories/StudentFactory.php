<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {

    return [
        // student number mixture of uppercase  letters and numbers minimum of _ characters in length
        'student_number' => $faker->toUpper($faker->unique()->randomLetter). $faker->unique()->randomNumber(4) 
                        . $faker->unique()->randomNumber(4),
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_name' => $faker->lastName,
        'suffix' => $faker->optional()->suffix,
        'status' => 'active',
        'deleted_at' => null,
    ];
});

