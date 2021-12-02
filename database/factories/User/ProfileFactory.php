<?php

use App\Domains\User\Profile\ProfileEloquent;
use Faker\Generator as Faker;

$factory->define(ProfileEloquent::class, function (Faker $faker) {
    static $number = 6;

    $userId = $number++;
    $fullName = $faker->firstName . ' ' . $faker->lastName;
    $nickName = $faker->firstName;
    $email = $faker->unique()->email;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'user_id' => $userId,
        'full_name' => $fullName,
        'nick_name' => $nickName,
        'email' => $email,
        'created_at' => $createdAt
    ];
});
