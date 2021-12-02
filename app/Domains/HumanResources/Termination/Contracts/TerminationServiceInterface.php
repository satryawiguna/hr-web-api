<?php

namespace App\Domains\HumanResources\Termination\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface TerminationServiceInterface.
 */
interface TerminationServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * TerminationServiceInterface constructor.
     *
     * @param TerminationRepositoryInterface $repository
     */
    public function __construct(TerminationRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Termination.
     *
     * @param TerminationInterface $Termination
     *
     * @return mixed
     */
    public function create(TerminationInterface $Termination);

    /**
     * Update Termination.
     *
     * @param TerminationInterface $Termination
     *
     * @return mixed
     */
    public function update(TerminationInterface $Termination);

    /**
     * Delete Termination.
     *
     * @param TerminationInterface $Termination
     *
     * @return mixed
     */
    public function delete(TerminationInterface $Termination);

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
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return GenericCollectionResponse
     */
    public function terminationList(int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return GenericListSearchResponse
     */
    public function terminationListSearch(ListSearchRequest $request, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @return GenericPageSearchResponse
     */
    public function terminationPageSearch(PageSearchRequest $request, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null): GenericPageSearchResponse;

    //</editor-fold>
}
