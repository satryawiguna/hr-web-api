<?php

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\OtherEquipmentEloquent;
use Faker\Generator as Faker;

$factory->define(OtherEquipmentEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $name = $faker->sentence(3, true);
    $description = $faker->paragraph(rand(2, 10));
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'name' => $name,
        'description' => $description,
        'created_at' => $createdAt,
    ];
});
