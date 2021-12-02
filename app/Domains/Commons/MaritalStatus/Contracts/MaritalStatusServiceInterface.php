<?php

namespace App\Domains\Commons\MaritalStatus\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface MaritalStatusServiceInterface.
 */
interface MaritalStatusServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * MaritalStatusServiceInterface constructor.
     *
     * @param MaritalStatusRepositoryInterface $repository
     */
    public function __construct(MaritalStatusRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create MaritalMaritalStatus.
     *
     * @param MaritalStatusInterface $MaritalStatus
     *
     * @return mixed
     */
    public function create(MaritalStatusInterface $MaritalStatus): ObjectResponse;

    /**
     * Update MaritalMaritalStatus.
     *
     * @param MaritalStatusInterface $MaritalStatus
     *
     * @return mixed
     */
    public function update(MaritalStatusInterface $MaritalStatus): BasicResponse;

    /**
     * Delete MaritalMaritalStatus.
     *
     * @param MaritalStatusInterface $MaritalStatus
     *
     * @return mixed
     */
    public function delete(MaritalStatusInterface $MaritalStatus): BasicResponse;

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
    public function maritalStatusList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function maritalStatusListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function maritalStatusPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param MaritalStatusInterface $MaritalStatus
     * @return mixed
     */
    public function maritalStatusSetActive(MaritalStatusInterface $MaritalStatus): BasicResponse;

    /**
     * @param MaritalStatusInterface $MaritalStatus
     * @return ObjectResponse
     */
    public function maritalStatusSlug(MaritalStatusInterface $MaritalStatus): ObjectResponse;

    //</editor-fold>
}
