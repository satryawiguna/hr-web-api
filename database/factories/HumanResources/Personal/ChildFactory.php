<?php

use App\Domains\HumanResources\Personal\Employee\Child\ChildEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Commons\Gender\GenderEloquent;
use Faker\Generator as Faker;

$factory->define(ChildEloquent::class, function (Faker $faker) {
    $employeeId = EmployeeEloquent::select('id')->orderByRaw('RAND()')->first();
    $fullName = $faker->name;
    $nickName = $faker->firstName;
    $genderId = GenderEloquent::select('id')->orderByRaw('RAND()')->first();
    $order = $faker->numberBetween(1, 5);
    $birthPlace = $faker->city;
    $birthDate = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');
    $hasBPJSKesehatan = $faker->boolean;
    $BPJSKesehataNumber = ($hasBPJSKesehatan) ? $faker->randomNumber(8) : null;
    $BPJSKesehataDate = ($hasBPJSKesehatan) ? $faker->date($format = 'Y-m-d H:i:s', $max = 'now') : null;
    $BPJSKesehataClass = ($hasBPJSKesehatan) ? $faker->randomElement(['I', 'II', 'III']) : null;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'employee_id' => $employeeId,
        'full_name' => $fullName,
        'nick_name' => $nickName,
        'gender_id' => $genderId,
        'order' => $order,
        'birth_place' => $birthPlace,
        'birth_date'=> $birthDate,
        'has_bpjs_kesehatan' => $hasBPJSKesehatan,
        'bpjs_kesehatan_number' => $BPJSKesehataNumber,
        'bpjs_kesehatan_date' => $BPJSKesehataDate,
        'bpjs_kesehatan_class' => $BPJSKesehataClass,
        'created_at' => $createdAt
    ];
});
