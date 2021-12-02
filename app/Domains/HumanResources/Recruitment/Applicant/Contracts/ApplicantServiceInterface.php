<?php

namespace App\Domains\HumanResources\Recruitment\Applicant\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface ApplicantServiceInterface.
 */
interface ApplicantServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ApplicantServiceInterface constructor.
     *
     * @param ApplicantRepositoryInterface $repository
     */
    public function __construct(ApplicantRepositoryInterface $repository);

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
    public function applicantList(int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return mixed
     */
    public function applicantListSearch(ListSearchRequest $request, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $profileId
     * @param int|null $genderId
     * @param int|null $religionId
     * @param int|null $maritalStatusId
     * @param object|null $rangeBirthDate
     * @param object|null $rangePassportExpiredDate
     * @param object|null $rangeVisaExpiredDate
     * @return mixed
     */
    public function applicantPageSearch(PageSearchRequest $request, int $profileId = null, int $genderId = null, int $religionId = null, int $maritalStatusId = null, object $rangeBirthDate = null, object $rangePassportExpiredDate = null, object $rangeVisaExpiredDate = null): GenericPageSearchResponse;

    //</editor-fold>
}
