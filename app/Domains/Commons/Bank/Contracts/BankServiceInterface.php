<?php

namespace App\Domains\Commons\Bank\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface BankServiceInterface.
 */
interface BankServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * BankServiceInterface constructor.
     *
     * @param BankRepositoryInterface $repository
     */
    public function __construct(BankRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Bank.
     *
     * @param BankInterface $Bank
     *
     * @return mixed
     */
    public function create(BankInterface $Bank): ObjectResponse;

    /**
     * Update Bank.
     *
     * @param BankInterface $Bank
     *
     * @return mixed
     */
    public function update(BankInterface $Bank): BasicResponse;

    /**
     * Delete Bank.
     *
     * @param BankInterface $Bank
     *
     * @return mixed
     */
    public function delete(BankInterface $Bank): BasicResponse;

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
    public function bankList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function bankListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function bankPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param BankInterface $Bank
     * @return mixed
     */
    public function bankSetActive(BankInterface $Bank): BasicResponse;

    /**
     * @param BankInterface $Bank
     * @return ObjectResponse
     */
    public function bankSlug(BankInterface $Bank): ObjectResponse;

    //</editor-fold>
}
