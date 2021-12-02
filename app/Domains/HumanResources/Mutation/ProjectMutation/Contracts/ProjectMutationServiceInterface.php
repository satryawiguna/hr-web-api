<?php

namespace App\Domains\HumanResources\Mutation\ProjectMutation\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;

/**
 * Interface ProjectMutationServiceInterface.
 */
interface ProjectMutationServiceInterface
{
    /**
     * ProjectMutationServiceInterface constructor.
     *
     * @param ProjectMutationRepositoryInterface $repository
     */
    public function __construct(ProjectMutationRepositoryInterface $repository);

    /**
     * Create ProjectMutation.
     *
     * @param ProjectMutationInterface $ProjectMutation
     *
     * @return mixed
     */
    public function create(ProjectMutationInterface $ProjectMutation);

    /**
     * Update ProjectMutation.
     *
     * @param ProjectMutationInterface $ProjectMutation
     *
     * @return mixed
     */
    public function update(ProjectMutationInterface $ProjectMutation);

    /**
     * Delete ProjectMutation.
     *
     * @param int $employeeId
     * @param int $id
     * @return mixed
     */
    public function delete(int $employeeId, int $id): BasicResponse;

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
    public function showProjectMutation(int $employeeId, int $id): ObjectResponse;

    /**
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return GenericCollectionResponse
     */
    public function projectMutationList(int $employeeId = null, int $projectId = null, object $rangeMutationDate = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return GenericListSearchResponse
     */
    public function projectMutationListSearch(ListSearchRequest $request, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @return GenericPageSearchResponse
     */
    public function projectMutationPageSearch(PageSearchRequest $request, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null): GenericPageSearchResponse;

    //</editor-fold>
}
