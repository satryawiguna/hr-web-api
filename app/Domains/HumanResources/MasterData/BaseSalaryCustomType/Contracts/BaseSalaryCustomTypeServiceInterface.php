<?php

namespace App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface BaseSalaryCustomTypeServiceInterface.
 */
interface BaseSalaryCustomTypeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * BaseSalaryCustomTypeServiceInterface constructor.
     *
     * @param BaseSalaryCustomTypeRepositoryInterface $repository
     */
    public function __construct(BaseSalaryCustomTypeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create BaseSalaryCustomType.
     *
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     *
     * @return mixed
     */
    public function create(BaseSalaryCustomTypeInterface $BaseSalaryCustomType);

    /**
     * Update BaseSalaryCustomType.
     *
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     *
     * @return mixed
     */
    public function update(BaseSalaryCustomTypeInterface $BaseSalaryCustomType);

    /**
     * Delete BaseSalaryCustomType.
     *
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     *
     * @return mixed
     */
    public function delete(BaseSalaryCustomTypeInterface $BaseSalaryCustomType);

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
     * @param int|null $isActive
     * @return mixed
     */
    public function baseSalaryCustomTypeList(int $companyId = null, int $isActive = null);

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function baseSalaryCustomTypeListSearch(ListSearchRequest $request, int $companyId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function baseSalaryCustomTypePageSearch(PageSearchRequest $request, int $companyId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     * @return mixed
     */
    public function baseSalaryCustomTypeSetActive(BaseSalaryCustomTypeInterface $BaseSalaryCustomType): BasicResponse;

    /**
     * @param BaseSalaryCustomTypeInterface $BaseSalaryCustomType
     * @return ObjectResponse
     */
    public function baseSalaryCustomTypeSlug(BaseSalaryCustomTypeInterface $BaseSalaryCustomType): ObjectResponse;

    //</editor-fold>
}
