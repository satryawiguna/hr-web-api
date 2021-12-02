<?php

namespace App\Domains\HumanResources\MasterData\SalaryStructure\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface SalaryStructureServiceInterface.
 */
interface SalaryStructureServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * SalaryStructureServiceInterface constructor.
     *
     * @param SalaryStructureRepositoryInterface $repository
     */
    public function __construct(SalaryStructureRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create SalaryStructure.
     *
     * @param SalaryStructureInterface $SalaryStructure
     *
     * @return mixed
     */
    public function create(SalaryStructureInterface $SalaryStructure);

    /**
     * Update SalaryStructure.
     *
     * @param SalaryStructureInterface $SalaryStructure
     *
     * @return mixed
     */
    public function update(SalaryStructureInterface $SalaryStructure);

    /**
     * Delete SalaryStructure.
     *
     * @param SalaryStructureInterface $SalaryStructure
     *
     * @return mixed
     */
    public function delete(SalaryStructureInterface $SalaryStructure);

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
     * @param string|null $type
     * @param int|null $isActive
     * @return mixed
     */
    public function salaryStructureList(int $companyId = null, string $type = null, int $isActive = null);

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function salaryStructureListSearch(ListSearchRequest $request, int $companyId = null, string $type = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function salaryStructurePageSearch(PageSearchRequest $request, int $companyId = null, string $type = null,  int $isActive = null): GenericPageSearchResponse;

    /**
     * @param SalaryStructureInterface $SalaryStructure
     * @return mixed
     */
    public function salaryStructureSetActive(SalaryStructureInterface $SalaryStructure): BasicResponse;

    /**
     * @param SalaryStructureInterface $SalaryStructure
     * @return ObjectResponse
     */
    public function salaryStructureSlug(SalaryStructureInterface $SalaryStructure): ObjectResponse;

    //</editor-fold>
}
