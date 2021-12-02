<?php

namespace App\Domains\HumanResources\Mutation\PositionMutation\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Mutation\PositionMutation\Contracts\EloquentPositionMutationRepositoryInterface;
use Closure;

/**
 * Interface PositionMutationRepositoryInterface.
 */
interface PositionMutationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PositionMutationRepositoryInterface constructor.
     *
     * @param EloquentPositionMutationRepositoryInterface $eloquent
     */
    public function __construct(EloquentPositionMutationRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create PositionMutation.
     *
     * @param PositionMutationInterface $PositionMutation
     *
     * @return mixed
     */
    public function create(PositionMutationInterface $PositionMutation);

    /**
     * Update PositionMutation.
     *
     * @param PositionMutationInterface $PositionMutation
     *
     * @return mixed
     */
    public function update(PositionMutationInterface $PositionMutation);

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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return mixed
     */
    public function positionMutationList(int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function positionMutationListSearch(ListedSearchParameter $parameter, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param bool $count
     * @return mixed
     */
    public function positionMutationPageSearch(PagedSearchParameter $parameter, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null, bool $count = false);

    //</editor-fold>
}
