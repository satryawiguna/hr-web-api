<?php

namespace App\Domains\Commons\CompanyCategory\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface CompanyCategoryServiceInterface.
 */
interface CompanyCategoryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompanyCategoryServiceInterface constructor.
     *
     * @param CompanyCategoryRepositoryInterface $repository
     */
    public function __construct(CompanyCategoryRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create CompanyCategory.
     *
     * @param CompanyCategoryInterface $CompanyCategory
     *
     * @return mixed
     */
    public function create(CompanyCategoryInterface $CompanyCategory): ObjectResponse;

    /**
     * Update CompanyCategory.
     *
     * @param CompanyCategoryInterface $CompanyCategory
     *
     * @return mixed
     */
    public function update(CompanyCategoryInterface $CompanyCategory): BasicResponse;

    /**
     * Delete CompanyCategory.
     *
     * @param CompanyCategoryInterface $CompanyCategory
     *
     * @return mixed
     */
    public function delete(CompanyCategoryInterface $CompanyCategory): BasicResponse;

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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function companyCategoryList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function companyCategoryListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function companyCategoryPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param CompanyCategoryInterface $CompanyCategory
     * @return mixed
     */
    public function companyCategorySetActive(CompanyCategoryInterface $CompanyCategory): BasicResponse;

    /**
     * @param CompanyCategoryInterface $CompanyCategory
     * @return ObjectResponse
     */
    public function companyCategorySlug(CompanyCategoryInterface $CompanyCategory): ObjectResponse;

    //</editor-fold>
}
