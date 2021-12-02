<?php

namespace App\Domains\Commons\VacancyCategory\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface VacancyCategoryServiceInterface.
 */
interface VacancyCategoryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyCategoryServiceInterface constructor.
     *
     * @param VacancyCategoryRepositoryInterface $repository
     */
    public function __construct(VacancyCategoryRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create VacancyCategory.
     *
     * @param VacancyCategoryInterface $VacancyCategory
     *
     * @return mixed
     */
    public function create(VacancyCategoryInterface $VacancyCategory): ObjectResponse;

    /**
     * Update VacancyCategory.
     *
     * @param VacancyCategoryInterface $VacancyCategory
     *
     * @return mixed
     */
    public function update(VacancyCategoryInterface $VacancyCategory): BasicResponse;

    /**
     * Delete VacancyCategory.
     *
     * @param VacancyCategoryInterface $VacancyCategory
     *
     * @return mixed
     */
    public function delete(VacancyCategoryInterface $VacancyCategory): BasicResponse;

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
     * @return GenericCollectionResponse
     */
    public function vacancyCategoryList(): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @return GenericListSearchResponse
     */
    public function vacancyCategoryListSearch(ListSearchRequest $request): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @return GenericPageSearchResponse
     */
    public function vacancyCategoryPageSearch(PageSearchRequest $request): GenericPageSearchResponse;

    /**
     * @param VacancyCategoryInterface $VacancyCategory
     * @return ObjectResponse
     */
    public function vacancyCategorySlug(VacancyCategoryInterface $VacancyCategory): ObjectResponse;

    //</editor-fold>
}
