<?php

namespace App\Domains\Demo\Employee\Contracts;


use App\Domains\Contracts\BaseEntityInterface;
use DateTime;

interface EmployeeInterface extends BaseEntityInterface
{
    const TABLE_NAME = 'demo_employees';
    const MORPH_NAME = 'demo_employees';

    public function getNip();

    public function setNip(string $nip);

    public function getFullName();

    public function setFullName(string $full_name);

    public function getNickName();

    public function setNickName(string $nick_name);

    public function getBirthDate();

    public function setBirthDate(DateTime $birth_date);

    public function getAddress();

    public function setAddress(string $address);

    public function getPhone();

    public function setPhone(string $phone);

    public function getMobile();

    public function setMobile(string $mobile);

    public function getEmail();

    public function setEmail(string $email);

    public function getCreatedBy();

    public function setCreatedBy(string $created_by);

    public function getModifiedBy();

    public function setModifiedBy(string $modified_by);
}