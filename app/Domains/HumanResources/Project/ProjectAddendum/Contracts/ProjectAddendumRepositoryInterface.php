<?php
namespace App\Domains\HumanResources\Project\ProjectAddendum\Contracts;


use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Project\ProjectAddendum\Contracts\EloquentProjectAddendumRepositoryInterface;
use Closure;
use DateTime;

/**
 * Interface ProjectAddendumRepositoryInterface.
 */
interface ProjectAddendumRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectAddendumRepositoryInterface constructor.
     *
     * @param EloquentProjectAddendumRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectAddendumRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ProjectAddendum.
     *
     * @param ProjectAddendumInterface $ProjectAddendum
     *
     * @param array|null $relations
     * @return mixed
     */
    public function create(ProjectAddendumInterface $ProjectAddendum, array $relations = null);

    /**
     * Update ProjectAddendum.
     *
     * @param ProjectAddendumInterface $ProjectAddendum
     *
     * @param array|null $relations
     * @return mixed
     */
    public function update(ProjectAddendumInterface $ProjectAddendum, array $relations = null);

    /**
     * Delete ProjectAddendum.
     *
     * @param ProjectAddendumInterface $ProjectAddendum
     *
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function delete(ProjectAddendumInterface $ProjectAddendum, bool $isPermanentDelete = false,  array $relations = null);

    /**
     * @param array $ids
     * @param bool $isPermanentDelete
     * @param array|null $relations
     * @return mixed
     */
    public function deleteBulk(array $ids, bool $isPermanentDelete = false,  array $relations = null);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $projectId
     * @param DateTime|null $date
     * @param object|null $rangeIssueDate
     * @param object|null $rangeValue
     * @param object|null $rangeValueByContractType
     * @return mixed
     */
    public function projectAddendumList(int $projectId = null, DateTime $date = null, object $rangeIssueDate = null, object $rangeValue = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $projectId
     * @param DateTime|null $date
     * @param object|null $rangeIssueDate
     * @param object|null $rangeValue
     * @param object|null $rangeValueByContractType
     * @param bool $count
     * @return mixed
     */
    public function projectAddendumListSearch(ListedSearchParameter $parameter, int $projectId = null, DatetIme $date = null, object $rangeIssueDate = null, object $rangeValue = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $projectId
     * @param DateTime|null $date
     * @param object|null $rangeIssueDate
     * @param object|null $rangeValue
     * @param object|null $rangeValueByContractType
     * @param bool $count
     * @return mixed
     */
    public function projectAddendumPageSearch(PagedSearchParameter $parameter, int $projectId = null, DateTime $date = null, object $rangeIssueDate = null, object $rangeValue = null, bool $count = false);

    //</editor-fold>
}
