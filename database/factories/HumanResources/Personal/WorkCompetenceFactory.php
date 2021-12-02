<?php

use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Employee\WorkCompetence\WorkCompetenceEloquent;
use Faker\Generator as Faker;

$factory->define(WorkCompetenceEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $referenceNumber = $faker->isbn13;
    $competenceId = CompetenceEloquent::select('id')->orderByRaw('RAND()')->first();
    $issueDate = $faker->date('Y-m-d', 'now');
    $validity = $faker->sentence(3, true);
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'reference_number' => $referenceNumber,
        'competence_id' => $competenceId,
        'issue_date' => $issueDate,
        'validity' => $validity,
        'created_at' => $createdAt,
    ];
});
