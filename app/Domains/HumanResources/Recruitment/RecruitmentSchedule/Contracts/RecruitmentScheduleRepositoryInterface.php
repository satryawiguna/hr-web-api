<?php

namespace App\Domains\HumanResources\Recruitment\RecruitmentSchedule\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\BaseEntityInterface;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Recruitment\RecruitmentSchedule\Contracts\EloquentRecruitmentScheduleRepositoryInterface;
use Closure;

/**
 * Interface RecruitmentScheduleRepositoryInterface.
 */
interface RecruitmentScheduleRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RecruitmentScheduleRepositoryInterface constructor.
     *
     * @param EloquentRecruitmentScheduleRepositoryInterface $eloquent
     */
    public function __construct(EloquentRecruitmentScheduleRepositoryInterface $eloquent);

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
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $vacancyApplicationIdyy
     * @param object|null $rangeScheduleDate
     * @return mixed
     */
    public function recruitmentScheduleList(int $vacancyApplicationIdyy = null, object $rangeScheduleDate = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $vacancyApplicationIdyy
     * @param object|null $rangeScheduleDate
     * @param bool $count
     * @return mixed
     */
    public function recruitmentScheduleListSearch(ListedSearchParameter $parameter, int $vacancyApplicationIdyy = null, object $rangeScheduleDate = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $vacancyApplicationIdyy
     * @param object|null $rangeScheduleDate
     * @param bool $count
     * @return mixed
     */
    public function recruitmentSchedulePageSearch(PagedSearchParameter $parameter, int $vacancyApplicationIdyy = null, object $rangeScheduleDate = null, bool $count = false);

    //</editor-fold>
}
