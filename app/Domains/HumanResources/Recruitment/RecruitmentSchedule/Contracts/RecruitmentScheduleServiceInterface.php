<?php

namespace App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface RecruitmentScheduleServiceInterface.
 */
interface RecruitmentScheduleServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RecruitmentScheduleServiceInterface constructor.
     *
     * @param RecruitmentScheduleRepositoryInterface $repository
     */
    public function __construct(RecruitmentScheduleRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create RecruitmentSchedule.
     *
     * @param RecruitmentScheduleInterface $RecruitmentSchedule
     *
     * @return mixed
     */
    public function create(RecruitmentScheduleInterface $RecruitmentSchedule);

    /**
     * Update RecruitmentSchedule.
     *
     * @param RecruitmentScheduleInterface $RecruitmentSchedule
     *
     * @return mixed
     */
    public function update(RecruitmentScheduleInterface $RecruitmentSchedule);

    /**
     * Delete RecruitmentSchedule.
     *
     * @param RecruitmentScheduleInterface $RecruitmentSchedule
     *
     * @return mixed
     */
    public function delete(RecruitmentScheduleInterface $RecruitmentSchedule);

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return GenericCollectionResponse
     */
    public function recruitmentScheduleList(int $vacancyApplicationId = null, object $rangeScheduleDate = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return GenericListSearchResponse
     */
    public function recruitmentScheduleListSearch(ListSearchRequest $request, int $vacancyApplicationId = null, object $rangeScheduleDate = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $vacancyApplicationId
     * @param object|null $rangeScheduleDate
     * @return GenericPageSearchResponse
     */
    public function recruitmentSchedulePageSearch(PageSearchRequest $request, int $vacancyApplicationId = null, object $rangeScheduleDate = null): GenericPageSearchResponse;

    //</editor-fold>
}
