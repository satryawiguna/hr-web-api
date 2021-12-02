<?php

namespace App\Domains\HumanResources\Project\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\HumanResources\Project\Contracts\Request\CreateProjectRequest;
use App\Domains\HumanResources\Project\Contracts\Request\EditProjectRequest;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\ProjectAddendumRepositoryInterface;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request\CreateProjectAddendumRequest;
use App\Domains\HumanResources\Project\ProjectAddendum\Contracts\Request\EditProjectAddendumRequest;
use DateTime;

/**
 * Interface ProjectServiceInterface.
 */
interface ProjectServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ProjectServiceInterface constructor.
     *
     * @param ProjectRepositoryInterface $repository
     */
    public function __construct(ProjectRepositoryInterface $repository, ProjectAddendumRepositoryInterface $repositoryProjectAddendums);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @param CreateProjectRequest $request
     * @return mixed
     */
    public function create(CreateProjectRequest $request): ObjectResponse;

    /**
     * @param CreateProjectAddendumRequest $request
     * @return BasicResponse
     */
    public function createProjectAddendum(CreateProjectAddendumRequest $request): BasicResponse;

    /**
     * @param EditProjectRequest $request
     * @return mixed
     */
    public function update(EditProjectRequest $request): ObjectResponse;

    /**
     * @param EditProjectAddendumRequest $request
     * @return BasicResponse
     */
    public function updateProjectAddendum(EditProjectAddendumRequest $request): BasicResponse;

    /**
     * Delete Project.
     *
     * @param ProjectInterface $Project
     *
     * @return mixed
     */
    public function delete(ProjectInterface $Project);

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
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function projectList(int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericCollectionResponse;

    /**
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericCollectionResponse
     */
    public function projectListHierarchical(int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericListSearchResponse
     */
    public function projectListSearch(ListSearchRequest $request, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $parentId
     * @param int|null $companyId
     * @param int|null $contractTypeId
     * @param object|null $rangeIssueDate
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @return GenericPageSearchResponse
     */
    public function projectPageSearch(PageSearchRequest $request, int $parentId = null, int $companyId = null, int $contractTypeId = null, object $rangeIssueDate = null, DateTime $date = null, object $rangeValue = null): GenericPageSearchResponse;

    //</editor-fold>
}
