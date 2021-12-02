<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use Illuminate\Support\Collection;

/**
 * Interface WorkCompetenceServiceInterface.
 */
interface WorkCompetenceServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkCompetenceServiceInterface constructor.
     *
     * @param WorkCompetenceRepositoryInterface $repository
     */
    public function __construct(WorkCompetenceRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkCompetence.
     *
     * @param WorkCompetenceInterface $WorkCompetence
     *
     * @return mixed
     */
    public function create(WorkCompetenceInterface $WorkCompetence);

    /**
     * @param Collection $WorkCompetences
     * @return mixed
     */
    public function insert(Collection $WorkCompetences);

    /**
     * Update WorkCompetence.
     *
     * @param WorkCompetenceInterface $WorkCompetence
     *
     * @param array $params
     * @return mixed
     */
    public function update(WorkCompetenceInterface $WorkCompetence, array $params = []);

    /**
     * Delete WorkCompetence.
     *
     * @param WorkCompetenceInterface $WorkCompetence
     *
     * @return mixed
     */
    public function delete(WorkCompetenceInterface $WorkCompetence);

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
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return GenericCollectionResponse
     */
    public function workCompetenceList(int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return GenericListSearchResponse
     */
    public function workCompetenceListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return GenericPageSearchResponse
     */
    public function workCompetencePageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null): GenericPageSearchResponse;

    //</editor-fold>
}
