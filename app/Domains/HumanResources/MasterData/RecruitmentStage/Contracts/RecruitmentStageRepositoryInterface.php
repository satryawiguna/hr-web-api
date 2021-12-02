<?php

namespace App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\RecruitmentStage\Contracts\EloquentRecruitmentStageRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface RecruitmentStageRepositoryInterface.
 */
interface RecruitmentStageRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RecruitmentStageRepositoryInterface constructor.
     *
     * @param EloquentRecruitmentStageRepositoryInterface $eloquent
     */
    public function __construct(EloquentRecruitmentStageRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create RecruitmentStage.
     *
     * @param RecruitmentStageInterface $RecruitmentStage
     *
     * @return mixed
     */
    public function create(RecruitmentStageInterface $RecruitmentStage);

    /**
     * Update RecruitmentStage.
     *
     * @param RecruitmentStageInterface $RecruitmentStage
     *
     * @return mixed
     */
    public function update(RecruitmentStageInterface $RecruitmentStage);

    /**
     * Delete RecruitmentStage.
     *
     * @param RecruitmentStageInterface $RecruitmentStage
     *
     * @return mixed
     */
    public function delete(RecruitmentStageInterface $RecruitmentStage);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $companyId
     * @return mixed
     */
    public function recruitmentStageList(int $companyId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param bool $count
     * @return mixed
     */
    public function recruitmentStageListSearch(ListedSearchParameter $parameter, int $companyId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param bool $count
     * @return mixed
     */
    public function recruitmentStagePageSearch(PagedSearchParameter $parameter, int $companyId = null, bool $count = false);

    //</editor-fold>
}
