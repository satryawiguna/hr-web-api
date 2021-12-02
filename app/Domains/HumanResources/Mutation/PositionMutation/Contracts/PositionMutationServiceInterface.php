<?php

namespace App\Domains\HumanResources\Mutation\PositionMutation\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;

/**
 * Interface PositionMutationServiceInterface.
 */
interface PositionMutationServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * PositionMutationServiceInterface constructor.
     *
     * @param PositionMutationRepositoryInterface $repository
     */
    public function __construct(PositionMutationRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create PositionMutation.
     *
     * @param PositionMutationInterface $PositionMutation
     *
     * @return mixed
     */
    public function create(PositionMutationInterface $PositionMutation);

    /**
     * Update PositionMutation.
     *
     * @param PositionMutationInterface $PositionMutation
     *
     * @return mixed
     */
    public function update(PositionMutationInterface $PositionMutation);

    /**
     * @param int $employeeId
     * @param int $id
     * @return BasicResponse
     */
    public function delete(int $employeeId, int $id): BasicResponse;

    /**
     * @param int $employeeId
     * @param array $ids
     * @return BasicResponse
     */
    public function deleteBulk(int $employeeId, array $ids): BasicResponse;

    /**
     * @param int $employeeId
     * @param int $id
     * @return ObjectResponse
     */
    public function showPositionMutation(int $employeeId, int $id): ObjectResponse;

    /**
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return GenericCollectionResponse
     */
    public function positionMutationList(int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return GenericListSearchResponse
     */
    public function positionMutationListSearch(ListSearchRequest $request, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function positionMutationPageSearch(PageSearchRequest $request, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null): GenericPageSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $positionId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function positionMutationPageSearchCompany(PageSearchRequest $request, int $companyId = null, int $positionId = null, object $rangeMutationDate = null): GenericPageSearchResponse;

    //</editor-fold>
}
