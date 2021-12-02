<?php

namespace App\Domains\HumanResources\Recruitment\VacancyApplicant\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface VacancyApplicantServiceInterface.
 */
interface VacancyApplicantServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyApplicantServiceInterface constructor.
     *
     * @param VacancyApplicantRepositoryInterface $repository
     */
    public function __construct(VacancyApplicantRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create VacancyApplicant.
     *
     * @param VacancyApplicantInterface $VacancyApplicant
     *
     * @return mixed
     */
    public function create(VacancyApplicantInterface $VacancyApplicant): ObjectResponse;

    /**
     * Update VacancyApplicant.
     *
     * @param VacancyApplicantInterface $VacancyApplicant
     *
     * @return mixed
     */
    public function updateStatus(VacancyApplicantInterface $VacancyApplicant): BasicResponse;

    /**
     * Delete VacancyApplicant.
     *
     * @param VacancyApplicantInterface $VacancyApplicant
     *
     * @return mixed
     */
    public function jobOnBoard(VacancyApplicantInterface $VacancyApplicant): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function note(VacancyApplicantInterface $VacancyApplicant): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return mixed
     */
    public function vacancyApplicantList(int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return GenericListSearchResponse
     */
    public function vacancyApplicantListSearch(ListSearchRequest $request, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $applicantId
     * @param int|null $vacancyId
     * @param int|null $recruitmentStageId
     * @param string|null $rating
     * @return GenericPageSearchResponse
     */
    public function vacancyApplicantPageSearch(PageSearchRequest $request, int $applicantId = null, int $vacancyId = null, int $recruitmentStageId = null, string $rating = null): GenericPageSearchResponse;

    //</editor-fold>
}
