<?php

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\MasterData\Competence\CompetenceEloquent;
use Faker\Generator as Faker;

$factory->define(CompetenceEloquent::class, function (Faker $faker) {
    $companyId = CompanyEloquent::select('id')->orderByRaw('RAND()')->first();
    $code = $faker->unique()->numberBetween(10000, 99999);
    $name = $faker->unique()->sentence(4, true);
    $slug = strtolower(str_replace(' ', '-', $name));
    $description = $faker->paragraph(rand(2, 10));

    return [
        'company_id' => $companyId,
        'code' => $code,
        'name' => $name,
        'slug' => $slug,
        'description' => $description,
    ];
});
