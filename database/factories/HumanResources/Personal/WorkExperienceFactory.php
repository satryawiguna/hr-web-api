<?php

use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkExperience\WorkExperienceEloquent;
use Faker\Generator as Faker;

$factory->define(WorkExperienceEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $company = $faker->randomElement(['PT.', 'CV.']) . ' ' . $faker->company;
    $businessType = $faker->randomElement(['IT', 'Accounting', 'Finance', 'Property']);
    $position = $faker->randomElement(['Manager', 'Staff', 'Programmer', 'Designer', 'Security']);
    $startDate = $faker->date('Y-m-d', 'now');
    $endDate = date('Y-m-d', strtotime('+'. rand(10, 100) .' days', strtotime($startDate)));
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'company' => $company,
        'business_type' => $businessType,
        'position' => $position,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'created_at' => $createdAt,
    ];
});
