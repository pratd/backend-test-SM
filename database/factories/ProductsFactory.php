<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\products;
use App\User;
use App\Providers;
use Faker\Generator as Faker;
use  Illuminate\Support\Facades\DB;

$factory->define(products::class, function (Faker $faker) {
    $providerIds = Providers::all()->pluck('id')->toArray();
    return [
        'name' => $faker->name,
        'provider_company' => $faker->name,
        'type' => $faker->text(5),
        'mime' => $faker->mimeType,
        'filename'=>$faker->fileExtension,
        'original_filename'=> $faker->fileExtension,
        'description'=>$faker->paragraph(5),
        'user_id'=>$faker->randomElement(User::all()->pluck('id')->toArray()) ,
        'provider_id'=>$faker->randomElement(Providers::all()->pluck('id')->toArray())
    ];
});
