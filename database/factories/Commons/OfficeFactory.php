<?php

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\Commons\Office\OfficeEloquent;
use Faker\Generator as Faker;

$factory->define(OfficeEloquent::class, function (Faker $faker) {
    $name = $faker->unique()->sentence(4, true);
    $slug = strtolower(str_replace(' ', '-', $name));
    $type = $faker->shuffle(['HEAD', 'BRANCH']);
    $country = $faker->countryCode;
    $stateOrProvince = $faker->city;
    $city = $faker->city;
    $address = $faker->address;
    $postCode = $faker->postcode;
    $phone = $faker->phoneNumber;
    $fax = $faker->phoneNumber;
    $email = $faker->email;
    $latitude = $faker->latitude;
    $longitude = $faker->longitude;
    $isActive = (int) $faker->boolean;
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'company_id' => CompanyEloquent::select('id')->orderByRaw('RAND()')->first(),
        'name' => $name,
        'slug' => $slug,
        'type' => 'BRANCH',
        'country' => $country,
        'state_or_province' => $stateOrProvince,
        'city' => $city,
        'address' => $address,
        'postcode' => $postCode,
        'phone' => $phone,
        'fax' => $fax,
        'email' => $email,
        'latitude' => $latitude,
        'longitude' => $longitude,
        'is_active' => $isActive,
        'created_by' => 'system',
        'modified_by' => null,
        'created_at' => $createdAt,
        'updated_at' => null,
        'deleted_at' => null
    ];
});
