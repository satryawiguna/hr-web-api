<?php

namespace App\Domains\HumanResources\Vacancy\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Vacancy\Contracts\Request\CreateVacancyRequest;
use App\Domains\HumanResources\Vacancy\Contracts\Request\EditVacancyRequest;

/**
 * Interface VacancyServiceInterface.
 */
interface VacancyServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyServiceInterface constructor.
     *
     * @param VacancyRepositoryInterface $repository
     */
    public function __construct(VacancyRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Vacancy.
     *
     * @param VacancyInterface $Vacancy
     *
     * @return mixed
     */
    public function create(CreateVacancyRequest $request): ObjectResponse;

    /**
     * Update Vacancy.
     *
     * @param VacancyInterface $Vacancy
     *
     * @return mixed
     */
    public function update(EditVacancyRequest $request): ObjectResponse;

    /**
     * Delete Vacancy.
     *
     * @param VacancyInterface $Vacancy
     *
     * @return mixed
     */
    public function delete(VacancyInterface $Vacancy);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return mixed
     */
    public function vacancyList(int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return mixed
     */
    public function vacancyListSearch(ListSearchRequest $request, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param null $companyId
     * @param null $vacancyLocationId
     * @param null $vacancyCategoryId
     * @param null $rangePublishDate
     * @param null $rangeExpiredDate
     * @param null $workStatus
     * @param null $workType
     * @param null $status
     * @return mixed
     */
    public function vacancyPageSearch(PageSearchRequest $request, int $companyId = null, int $vacancyLocationId = null, int $vacancyCategoryId = null, object $rangePublishDate = null, object $rangeExpiredDate = null, string $workStatus = null, string $workType = null, string $status = null): GenericPageSearchResponse;

    /**
     * @param VacancyInterface $Vacancy
     * @return BasicResponse
     */
    public function vacancySetPublish(VacancyInterface $Vacancy): BasicResponse;

    /**
     * @param VacancyInterface $Vacancy
     * @return BasicResponse
     */
    public function vacancySetDraft(VacancyInterface $Vacancy): BasicResponse;

    /**
     * @param VacancyInterface $Vacancy
     * @return BasicResponse
     */
    public function vacancySetPending(VacancyInterface $Vacancy): BasicResponse;

    //</editor-fold>
}
