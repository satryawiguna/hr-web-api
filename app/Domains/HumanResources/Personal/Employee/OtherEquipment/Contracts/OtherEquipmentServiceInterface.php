<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use Illuminate\Support\Collection;

/**
 * Interface OtherEquipmentServiceInterface.
 */
interface OtherEquipmentServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OtherEquipmentServiceInterface constructor.
     *
     * @param OtherEquipmentRepositoryInterface $repository
     */
    public function __construct(OtherEquipmentRepositoryInterface $repository);

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
     * @param array $params
     * @return mixed
     */
    public function update(OtherEquipmentInterface $OtherEquipment, array $params = []);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @return GenericCollectionResponse
     */
    public function otherEquipmentList(int $companyId = null, int $employeeId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @return GenericListSearchResponse
     */
    public function otherEquipmentListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @return GenericPageSearchResponse
     */
    public function otherEquipmentPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null): GenericPageSearchResponse;

    //</editor-fold>
}