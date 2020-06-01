<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\providers;
use Faker\Generator as Faker;
use App\User;
$factory->define(providers::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->text(10),
        'telephone' => $faker->text(10),
        'city'=>$faker->city,
        'user_id'=>$faker->randomElement(User::all()->pluck('id')->toArray()) ,
    ];
});
