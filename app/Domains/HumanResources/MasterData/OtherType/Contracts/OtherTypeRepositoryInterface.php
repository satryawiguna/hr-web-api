<?php

namespace App\Domains\HumanResources\MasterData\OtherType\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\OtherType\Contracts\EloquentOtherTypeRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface OtherTypeRepositoryInterface.
 */
interface OtherTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OtherTypeRepositoryInterface constructor.
     *
     * @param EloquentOtherTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentOtherTypeRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create OtherType.
     *
     * @param OtherTypeInterface $OtherType
     *
     * @return mixed
     */
    public function create(OtherTypeInterface $OtherType);

    /**
     * Update OtherType.
     *
     * @param OtherTypeInterface $OtherType
     *
     * @return mixed
     */
    public function update(OtherTypeInterface $OtherType);

    /**
     * Delete OtherType.
     *
     * @param OtherTypeInterface $OtherType
     *
     * @return mixed
     */
    public function delete(OtherTypeInterface $OtherType);

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
    public function otherTypeList(int $companyId = null, int $isActive = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function otherTypeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function otherTypePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false);

    //</editor-fold>
}
