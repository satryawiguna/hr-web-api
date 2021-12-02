<?php

use App\Domains\Commons\Company\CompanyEloquent;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\Commons\Gender\GenderEloquent;
use App\Domains\Commons\MaritalStatus\MaritalStatusEloquent;
use App\Domains\Commons\Office\OfficeEloquent;
use App\Domains\Commons\Religion\ReligionEloquent;
use App\Domains\HumanResources\MasterData\WorkArea\WorkAreaEloquent;
use Faker\Generator as Faker;

$factory->define(EmployeeEloquent::class, function (Faker $faker) {
    $companyId = CompanyEloquent::select('id')->orderByRaw('RAND()')->first();
    $nip = $faker->unique()->isbn13;
    $fullName = $faker->name;
    $nickName = $faker->firstName;
    $genderId = GenderEloquent::select('id')->orderByRaw('RAND()')->first();
    $religionId = ReligionEloquent::select('id')->orderByRaw('RAND()')->first();
    $birthPlace = $faker->city;
    $birthDate = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');
    $address = $faker->address;
    $phone = $faker->phoneNumber;
    $mobile = $faker->phoneNumber;
    $email = $faker->email;
    $identityNumber = $faker->randomDigit(10);
    $identityExpiredDate = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');
    $identityAddress = $faker->address;
    $hasDriveLicenseA = 0;
    $hasDriveLicenseB = 0;
    $hasDriveLicenseC = 0;
    $maritalStatusId = MaritalStatusEloquent::select('id')->orderByRaw('RAND()')->first();
    $officeId = OfficeEloquent::select('id')->orderByRaw('RAND()')->first();
    $workAreaId = WorkAreaEloquent::select('id')->orderByRaw('RAND()')->first();
    $hasNPWP = 0;
    $hasBPJSTenagaKerja = 0;
    $hasBPJSKesehatan = 0;
    $hasMateBPJSKesehatan = 0;
    $joinDate = $faker->date($format = 'Y-m-d H:i:s', 'now');
    $workStatus = $faker->shuffle(['FULL_TIME', 'PART_TIME'])[0];
    $workType = $faker->shuffle(['PERMANENT', 'CONTRACT'])[0];
    $createdAt = $faker->date($format = 'Y-m-d H:i:s', $max = 'now');

    return [
        'company_id' => $companyId,
        'nip' => $nip,
        'full_name' => $fullName,
        'nick_name' => $nickName,
        'gender_id' => $genderId,
        'religion_id' => $religionId,
        'birth_place' => $birthPlace,
        'birth_date' => $birthDate,
        'address' => $address,
        'phone' => $phone,
        'mobile' => $mobile,
        'email' => $email,
        'identity_number' => $identityNumber,
        'identity_expired_date' => $identityExpiredDate,
        'identity_address' => $identityAddress,
        'has_drive_license_a' => $hasDriveLicenseA,
        'has_drive_license_b' => $hasDriveLicenseB,
        'has_drive_license_c' => $hasDriveLicenseC,
        'marital_status_id' => $maritalStatusId,
        'office_id' => $officeId,
        'work_area_id' => $workAreaId,
        'has_NPWP' => $hasNPWP,
        'has_BPJS_tenaga_kerja' => $hasBPJSTenagaKerja,
        'has_BPJS_kesehatan' => $hasBPJSKesehatan,
        'has_mate_BPJS_kesehatan' => $hasMateBPJSKesehatan,
        'join_date' => $joinDate,
        'work_status' => $workStatus,
        'work_type' => $workType,
        'created_by' => 'system',
        'modified_by' => null,
        'created_at' => $createdAt,
        'updated_at' => null,
        'deleted_at' => null
    ];
});
