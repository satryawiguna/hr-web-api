<?php

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use Faker\Generator as Faker;

$factory->define(WorkAreaEloquent::class, function (Faker $faker) {
    $companyId = CompanyEloquent::select('id')->orderByRaw('RAND()')->first();
    $code = $faker->unique()->numberBetween(10000, 99999);
    $title = $faker->unique()->sentence(4, true);
    $slug = strtolower(str_replace(' ', '-', $title));
    $country = $faker->countryCode;
    $stateOrProvince = $faker->city;
    $city = $faker->city;
    $address = $faker->address;
    $postCode = $faker->postcode;
    $phone = $faker->phoneNumber;
    $fax = $faker->phoneNumber;
    $email = $faker->email;
    $url = $faker-> url;
    $isActive = (int) $faker->boolean;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'company_id' => $companyId,
        'code' => $code,
        'title' => $title,
        'slug' => $slug,
        'country' => $country,
        'state_or_province' => $stateOrProvince,
        'city' => $city,
        'address' => $address,
        'postcode' => $postCode,
        'phone' => $phone,
        'fax' => $fax,
        'email' => $email,
        'url' => $url,
        'is_active' => $isActive,
        'created_by' => 'system',
        'modified_by' => null,
        'created_at' => $createdAt,
        'updated_at' => null,
        'deleted_at' => null
    ];
});
