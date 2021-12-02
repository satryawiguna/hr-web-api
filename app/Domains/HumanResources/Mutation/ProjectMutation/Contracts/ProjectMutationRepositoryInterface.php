<?php

namespace App\Domains\HumanResources\Mutation\ProjectMutation\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Mutation\ProjectMutation\Contracts\EloquentProjectMutationRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface ProjectMutationRepositoryInterface.
 */
interface ProjectMutationRepositoryInterface
{
    /**
     * ProjectMutationRepositoryInterface constructor.
     *
     * @param EloquentProjectMutationRepositoryInterface $eloquent
     */
    public function __construct(EloquentProjectMutationRepositoryInterface $eloquent);

    /**
     * Create ProjectMutation.
     *
     * @param ProjectMutationInterface $ProjectMutation
     *
     * @return mixed
     */
    public function create(ProjectMutationInterface $ProjectMutation);

    /**
     * Update ProjectMutation.
     *
     * @param ProjectMutationInterface $ProjectMutation
     *
     * @return mixed
     */
    public function update(ProjectMutationInterface $ProjectMutation);

    /**
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where);

    /**
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return mixed
     */
    public function projectMutationList(int $employeeId = null, int $projectId = null, object $rangeMutationDate = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function projectMutationListSearch(ListedSearchParameter $parameter, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function projectMutationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null, bool $count = false);

    //</editor-fold>
}
