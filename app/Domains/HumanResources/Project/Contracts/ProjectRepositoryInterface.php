<?php

namespace App\Domains\HumanResources\Project\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Project\Contracts\EloquentProjectRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;

/**
 * Interface ProjectRepositoryInterface.
 */
interface ProjectRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectRepositoryInterface constructor.
     *
     * @param EloquentProjectRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @param ProjectInterface $Project
     * @param array|null $relation
     * @return mixed
     */
    public function create(ProjectInterface $Project, array $relation = null);

    /**
     * @param ProjectInterface $Project
     * @param array|null $relation
     * @return mixed
     */
    public function update(ProjectInterface $Project, array $relation = null);

    /**
     * Delete Project.
     *
     * @param ProjectInterface $Project
     *
     * @param bool $isPermanentDelete
     * @param array|null $relation
     * @return mixed
     */
    public function delete(ProjectInterface $Project, bool $isPermanentDelete = false, array $relation = null);

    /**
     * @param array $ids
     * @param bool $isPermanentDelete
     * @param array|null $relation
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false, array $relation = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return mixed
     */
    public function projectList(int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null);

    /**
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return mixed
     */
    public function projectListHierarchical(int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectListSearch(ListedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param bool $count
     * @return mixed
     */
    public function projectPageSearch(PagedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null, bool $count = false);

    //</editor-fold>
}
