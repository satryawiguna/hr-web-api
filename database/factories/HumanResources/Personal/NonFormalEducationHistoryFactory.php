<?php

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\NonFormalEducationHistoryEloquent;
use Faker\Generator as Faker;

$factory->define(NonFormalEducationHistoryEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $type = $faker->sentence(3, true);
    $name = $faker->sentence(3, true);
    $startDate = $faker->date('Y-m-d', 'now');
    $endDate = date('Y-m-d', strtotime('+'. rand(10, 100) .' days', strtotime($startDate)));
    $institution = $faker->sentence(6, true);
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'type' => $type,
        'name' => $name,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'institution' => $institution,
        'created_at' => $createdAt,
    ];
});
