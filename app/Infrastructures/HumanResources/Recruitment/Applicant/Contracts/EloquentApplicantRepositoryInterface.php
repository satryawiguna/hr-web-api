<?php

namespace App\Infrastructures\HumanResources\Recruitment\Applicant\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;
use DateTime;

interface EloquentApplicantRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param int $profileId
     * @return mixed
     */
    public function findWhereByProfileId(int $profileId);

    /**
     * @param int $genderId
     * @return mixed
     */
    public function findWhereByGenderId(int $genderId);

    /**
     * @param int $religionId
     * @return mixed
     */
    public function findWhereByReligionId(int $religionId);

    /**
     * @param int $maritalStatusId
     * @return mixed
     */
    public function findWhereByMaritalStatusId(int $maritalStatusId);

    /**
     * @param string $country
     * @return mixed
     */
    public function findWhereByCountry(string $country);

    /**
     * @param DateTime $startBirthDate
     * @param DateTime $endBirthDate
     * @return mixed
     */
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, DateTime $endBirthDate);

    /**
     * @param DateTime $startPassportExpiredDate
     * @param DateTime $endPassportExpiredDate
     * @return mixed
     */
    public function findWhereBetweenByRangePassportExpiredDate(DateTime $startPassportExpiredDate, DateTime $endPassportExpiredDate);

    /**
     * @param DateTime $startVisaExpiredDate
     * @param DateTime $endVisaExpiredDate
     * @return mixed
     */
    public function findWhereBetweenByRangeVisaExpiredDate(DateTime $startVisaExpiredDate, DateTime $endVisaExpiredDate);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);


    //</editor-fold>
}
