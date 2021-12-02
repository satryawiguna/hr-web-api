<?php

use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use Faker\Generator as Faker;

$factory->define(MaritalStatusEloquent::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(4, true);
    $slug = strtolower(str_replace(' ', '-', $name));
    $description = $faker->paragraph(rand(2, 10));
    $isActive = (int) $faker->boolean;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'name' => $name,
        'slug' => $slug,
        'description' => $description,
        'is_active' => $isActive,
        'created_by' => 'system',
        'modified_by' => null,
        'created_at' => $createdAt,
        'updated_at' => null,
        'deleted_at' => null
    ];
});
