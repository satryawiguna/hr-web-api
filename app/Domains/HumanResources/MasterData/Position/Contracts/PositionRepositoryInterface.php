<?php

namespace App\Domains\HumanResources\MasterData\Position\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\Position\Contracts\EloquentPositionRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface PositionRepositoryInterface.
 */
interface PositionRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PositionRepositoryInterface constructor.
     *
     * @param EloquentPositionRepositoryInterface $eloquent
     */
    public function __construct(EloquentPositionRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Position.
     *
     * @param PositionInterface $Position
     *
     * @return mixed
     */
    public function create(PositionInterface $Position);

    /**
     * Update Position.
     *
     * @param PositionInterface $Position
     *
     * @return mixed
     */
    public function update(PositionInterface $Position);

    /**
     * Delete Position.
     *
     * @param PositionInterface $Position
     *
     * @return mixed
     */
    public function delete(PositionInterface $Position);

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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @return mixed
     */
    public function positionList(int $parentId = null, int $companyId = null, int $isActive = null);

    /**
     * @param int|null $companyId
     * @param int|null $isActive
     * @return mixed
     */
    public function positionListHierarchical(int $companyId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function positionListSearch(ListedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function positionPageSearch(PagedSearchParameter $parameter, int $parentId = null, int $companyId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
