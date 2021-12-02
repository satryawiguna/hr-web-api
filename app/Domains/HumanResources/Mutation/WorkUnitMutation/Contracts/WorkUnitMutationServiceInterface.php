<?php

namespace App\Domains\HumanResources\Mutation\WorkUnitMutation\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;

/**
 * Interface WorkUnitMutationServiceInterface.
 */
interface WorkUnitMutationServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkUnitMutationServiceInterface constructor.
     *
     * @param WorkUnitMutationRepositoryInterface $repository
     */
    public function __construct(WorkUnitMutationRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkUnitMutation.
     *
     * @param WorkUnitMutationInterface $WorkUnitMutation
     *
     * @return mixed
     */
    public function create(WorkUnitMutationInterface $WorkUnitMutation);

    /**
     * Update WorkUnitMutation.
     *
     * @param WorkUnitMutationInterface $WorkUnitMutation
     *
     * @return mixed
     */
    public function update(WorkUnitMutationInterface $WorkUnitMutation);

    /**
     * Delete ProjectMutation.
     *
     * @param int $employeeId
     * @param int $id
     * @return mixed
     */
    public function delete(WorkUnitMutationInterface $WorkUnitMutation): BasicResponse;

    /**
     * @param int $employeeId
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(int $employeeId, array $ids): BasicResponse;

    /**
     * @param int $employeeId
     * @param int $id
     * @return ObjectResponse
     */
    public function showWorkUnitMutation(int $employeeId, int $id): ObjectResponse;

    /**
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return GenericCollectionResponse
     */
    public function workUnitMutationList(int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return GenericListSearchResponse
     */
    public function workUnitMutationListSearch(ListSearchRequest $request, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function workUnitMutationPageSearch(PageSearchRequest $request, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null): GenericPageSearchResponse;

    //</editor-fold>
}
