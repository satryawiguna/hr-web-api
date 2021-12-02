<?php

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\OrganizationHistory\OrganizationHistoryEloquent;
use Faker\Generator as Faker;

$factory->define(OrganizationHistoryEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $name = $faker->sentence(3, true);
    $startDate = $faker->date('Y-m-d', 'now');
    $endDate = date('Y-m-d', strtotime('+'. rand(10, 100) .' days', strtotime($startDate)));
    $activity = $faker->sentence(6, true);
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'name' => $name,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'activity' => $activity,
        'created_at' => $createdAt,
    ];
});
