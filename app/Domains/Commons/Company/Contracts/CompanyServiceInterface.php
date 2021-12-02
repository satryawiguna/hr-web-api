<?php

namespace App\Domains\Commons\Company\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\Commons\Company\Contracts\Request\CreateCompanyRequest;
use App\Domains\Commons\Company\Contracts\Request\EditCompanyRequest;

/**
 * Interface CompanyServiceInterface.
 */
interface CompanyServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompanyServiceInterface constructor.
     *
     * @param CompanyRepositoryInterface $repository
     */
    public function __construct(CompanyRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Company.
     *
     * @param CreateCompanyRequest $request
     *
     * @return mixed
     */
    public function create(CreateCompanyRequest $request): ObjectResponse;

    /**
     * Update Company.
     *
     * @param EditCompanyRequest $request
     *
     * @return mixed
     */
    public function update(EditCompanyRequest $request): ObjectResponse;

    /**
     * Delete Company.
     *
     * @param CompanyInterface $Company
     *
     * @return mixed
     */
    public function delete(CompanyInterface $Company): BasicResponse;

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
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return GenericCollectionResponse
     */
    public function companyList(int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return mixed
     */
    public function companyListSearch(ListSearchRequest $request, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyCategoryId
     * @param int $employeeNumberScaleId
     * @param int $isActive
     * @return mixed
     */
    public function companyPageSearch(PageSearchRequest $request, int $companyCategoryId = null, int $employeeNumberScaleId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param CompanyInterface $Company
     * @return BasicResponse
     */
    public function companySetActive(CompanyInterface $Company): BasicResponse;

    /**
     * @param CompanyInterface $Company
     * @return ObjectResponse
     */
    public function companySlug(CompanyInterface $Company): ObjectResponse;

    //</editor-fold>
}
