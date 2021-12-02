<?php

use App\Domains\Commons\Degree\DegreeEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\FormalEducationHistoryEloquent;
use App\Domains\Commons\Major\MajorEloquent;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(FormalEducationHistoryEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $degreeId = DegreeEloquent::select('id')->orderByRaw('RAND()')->first();
    $majorId = MajorEloquent::select('id')->orderByRaw('RAND()')->first();
    $name = $faker->sentence(3, true);
    $startDate = $faker->date('Y-m-d', 'now');
    $endDate = date('Y-m-d', strtotime('+'. rand(10, 100) .' days', strtotime($startDate)));
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'degree_id' => $degreeId,
        'major_id' => $majorId,
        'name' => $name,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'created_at' => $createdAt,
    ];
});
