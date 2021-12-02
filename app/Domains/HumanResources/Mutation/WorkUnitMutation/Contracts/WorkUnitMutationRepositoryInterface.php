<?php

namespace App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Mutation\WorkUnitMutation\Contracts\EloquentWorkUnitMutationRepositoryInterface;
use Closure;

/**
 * Interface WorkUnitMutationRepositoryInterface.
 */
interface WorkUnitMutationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkUnitMutationRepositoryInterface constructor.
     *
     * @param EloquentWorkUnitMutationRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkUnitMutationRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkUnitMutation.
     *
     * @param WorkUnitMutationInterface $WorkUnitMutation
     *
     * @return mixed
     */
    public function create(WorkUnitMutationInterface $WorkUnitMutation);

    /**
     * Update WorkUnitMutation.
     *
     * @param WorkUnitMutationInterface $WorkUnitMutation
     *
     * @return mixed
     */
    public function update(WorkUnitMutationInterface $WorkUnitMutation);

    /**
     * @param array $where
     * @return mixed
     */
    public function deleteWhere(array $where);

    /**
     * @param array $where
     * @return mixed
     */
    public function findWhere(array $where);

    /**
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return mixed
     */
    public function workUnitMutationList(int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function workUnitMutationListSearch(ListedSearchParameter $parameter, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function workUnitMutationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, int $workUnitId = null, object  $rangeMutationDate = null, bool $count = false);

    //</editor-fold>
}
