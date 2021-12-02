<?php

namespace App\Domains\HumanResources\MasterData\Grade\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\Grade\Contracts\EloquentGradeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface GradeRepositoryInterface.
 */
interface GradeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * GradeRepositoryInterface constructor.
     *
     * @param EloquentGradeRepositoryInterface $eloquent
     */
    public function __construct(EloquentGradeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Grade.
     *
     * @param GradeInterface $Grade
     *
     * @return mixed
     */
    public function create(GradeInterface $Grade);

    /**
     * Update Grade.
     *
     * @param GradeInterface $Grade
     *
     * @return mixed
     */
    public function update(GradeInterface $Grade);

    /**
     * Delete Grade.
     *
     * @param GradeInterface $Grade
     *
     * @return mixed
     */
    public function delete(GradeInterface $Grade);

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
     * @param int|null $isActive
     * @return mixed
     */
    public function gradeList(int $companyId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function gradeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function gradePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
