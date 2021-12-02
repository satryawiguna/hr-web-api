<?php

namespace App\Domains\Commons\ContractType\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface ContractTypeServiceInterface.
 */
interface ContractTypeServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ContractTypeServiceInterface constructor.
     *
     * @param ContractTypeRepositoryInterface $repository
     */
    public function __construct(ContractTypeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create ContractType.
     *
     * @param ContractTypeInterface $ContractType
     *
     * @return mixed
     */
    public function create(ContractTypeInterface $ContractType): ObjectResponse;

    /**
     * Update ContractType.
     *
     * @param ContractTypeInterface $ContractType
     *
     * @return mixed
     */
    public function update(ContractTypeInterface $ContractType): BasicResponse;

    /**
     * Delete ContractType.
     *
     * @param ContractTypeInterface $ContractType
     *
     * @return mixed
     */
    public function delete(ContractTypeInterface $ContractType): BasicResponse;

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
    public function contractTypeList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function contractTypeListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function contractTypePageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param ContractTypeInterface $ContractType
     * @return mixed
     */
    public function contractTypeSetActive(ContractTypeInterface $ContractType): BasicResponse;

    /**
     * @param ContractTypeInterface $ContractType
     * @return ObjectResponse
     */
    public function contractTypeSlug(ContractTypeInterface $ContractType): ObjectResponse;

    //</editor-fold>
}
