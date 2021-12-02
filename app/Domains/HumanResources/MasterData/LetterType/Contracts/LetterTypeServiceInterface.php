<?php

namespace App\Domains\HumanResources\MasterData\LetterType\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface LetterTypeServiceInterface.
 */
interface LetterTypeServiceInterface
{
    //<editor-fold desc="#constructor">
    
    /**
     * LetterTypeServiceInterface constructor.
     *
     * @param LetterTypeRepositoryInterface $repository
     */
    public function __construct(LetterTypeRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create LetterType.
     *
     * @param LetterTypeInterface $LetterType
     *
     * @return mixed
     */
    public function create(LetterTypeInterface $LetterType);

    /**
     * Update LetterType.
     *
     * @param LetterTypeInterface $LetterType
     *
     * @return mixed
     */
    public function update(LetterTypeInterface $LetterType);

    /**
     * Delete LetterType.
     *
     * @param LetterTypeInterface $LetterType
     *
     * @return mixed
     */
    public function delete(LetterTypeInterface $LetterType);

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
     * @return GenericCollectionResponse
     */
    public function letterTypeList(int $companyId = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function letterTypeListSearch(ListSearchRequest $request, int $companyId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function letterTypePageSearch(PageSearchRequest $request, int $companyId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param LetterTypeInterface $LetterType
     * @return mixed
     */
    public function letterTypeSetActive(LetterTypeInterface $LetterType): BasicResponse;

    /**
     * @param LetterTypeInterface $LetterType
     * @return ObjectResponse
     */
    public function letterTypeSlug(LetterTypeInterface $LetterType): ObjectResponse;

    //</editor-fold>
}
