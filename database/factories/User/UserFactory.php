<?php
use App\Domains\User\UserEloquent;
use Faker\Generator as Faker;

$factory->define(UserEloquent::class, function (Faker $faker) {
    $username = $faker->unique()->userName;
    $email = $faker->unique()->email;
    $password = \Hash::make('12345');
    $isActive = true;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'is_active' => $isActive,
        'created_by' => 'system',
        'modified_by' => null,
        'created_at' => $createdAt,
        'updated_at' => null,
        'deleted_at' => null
    ];
});