<?php

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\CompanyCategory\CompanyCategoryEloquent;
use App\Domains\Commons\EmployeeNumberScale\EmployeeNumberScaleEloquent;
use Faker\Generator as Faker;

$factory->define(CompanyEloquent::class, function (Faker $faker) {
    $companyCategoryId = CompanyCategoryEloquent::select('id')->orderByRaw('RAND()')->first()->id;
    $employeeNumberScaleId = EmployeeNumberScaleEloquent::select('id')->orderByRaw('RAND()')->first()->id;
    $name = $faker->randomElement(['PT.', 'CV.']) . ' ' . $faker->company;
    $slug = strtolower(str_replace(' ', '-', $name));
    $email = $faker->companyEmail;
    $url = $faker->url;
    $description = $faker->paragraph(rand(2, 10));
    $isActive = (int) $faker->boolean;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'company_category_id' => $companyCategoryId,
        'employee_number_scale_id' => $employeeNumberScaleId,
        'name' => $name,
        'slug' => $slug,
        'email' => $email,
        'url' => $url,
        'description' => $description,
        'is_active' => $isActive,
        'created_by' => 'system',
        'modified_by' => null,
        'created_at' => $createdAt,
        'updated_at' => null,
        'deleted_at' => null
    ];
});
