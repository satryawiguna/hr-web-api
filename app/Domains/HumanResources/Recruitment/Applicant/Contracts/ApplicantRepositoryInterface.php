<?php

namespace App\Domains\HumanResources\Recruitment\Applicant\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\Applicant\Contracts\EloquentApplicantRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ApplicantRepositoryInterface.
 */
interface ApplicantRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ApplicantRepositoryInterface constructor.
     *
     * @param EloquentApplicantRepositoryInterface $eloquent
     */
    public function __construct(EloquentApplicantRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Applicant.
     *
     * @param ApplicantInterface $Applicant
     *
     * @return mixed
     */
    public function create(ApplicantInterface $Applicant);

    /**
     * Update Applicant.
     *
     * @param ApplicantInterface $Applicant
     *
     * @return mixed
     */
    public function update(ApplicantInterface $Applicant);

    /**
     * Delete Applicant.
     *
     * @param ApplicantInterface $Applicant
     *
     * @return mixed
     */
    public function delete(ApplicantInterface $Applicant);


    /**
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return mixed
     */
    public function applicantList(int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @param bool $count
     * @return mixed
     */
    public function applicantListSearch(ListedSearchParameter $parameter, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @param bool $count
     * @return mixed
     */
    public function applicantPageSearch(PagedSearchParameter $parameter, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null, bool $count = false);

    //</editor-fold>

}
