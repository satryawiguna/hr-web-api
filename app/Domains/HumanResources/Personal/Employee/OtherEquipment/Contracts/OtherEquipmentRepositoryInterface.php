<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\EloquentOtherEquipmentRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Collection;

/**
 * Interface OtherEquipmentRepositoryInterface.
 */
interface OtherEquipmentRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OtherEquipmentRepositoryInterface constructor.
     *
     * @param EloquentOtherEquipmentRepositoryInterface $eloquent
     */
    public function __construct(EloquentOtherEquipmentRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create OtherEquipment.
     *
     * @param OtherEquipmentInterface $OtherEquipment
     *
     * @return mixed
     */
    public function create(OtherEquipmentInterface $OtherEquipment);

    /**
     * @param Collection $OtherEquipments
     * @return mixed
     */
    public function insert(Collection $OtherEquipments);

    /**
     * Update OtherEquipment.
     *
     * @param OtherEquipmentInterface $OtherEquipment
     *
     * @return mixed
     */
    public function update(OtherEquipmentInterface $OtherEquipment);

    /**
     * @param OtherEquipmentInterface $OtherEquipment
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(OtherEquipmentInterface $OtherEquipment, array $params);

    /**
     * Delete OtherEquipment.
     *
     * @param OtherEquipmentInterface $OtherEquipment
     *
     * @return mixed
     */
    public function delete(OtherEquipmentInterface $OtherEquipment);

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
     * @param int|null $employeeId
     * @return mixed
     */
    public function otherEquipmentList(int $companyId = null, int $employeeId = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param bool $count
     * @return mixed
     */
    public function otherEquipmentListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param bool $count
     * @return mixed
     */
    public function otherEquipmentPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, bool $count = false);

    //</editor-fold>
}
