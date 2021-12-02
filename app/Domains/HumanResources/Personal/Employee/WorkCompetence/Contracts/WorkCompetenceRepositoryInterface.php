<?php

namespace App\Domains\HumanResources\Personal\Employee\WorkCompetence\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\WorkCompetence\Contracts\EloquentWorkCompetenceRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Collection;

/**
 * Interface WorkCompetenceRepositoryInterface.
 */
interface WorkCompetenceRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkCompetenceRepositoryInterface constructor.
     *
     * @param EloquentWorkCompetenceRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkCompetenceRepositoryInterface $eloquent);

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
     * @return mixed
     */
    public function update(WorkCompetenceInterface $WorkCompetence);

    /**
     * @param WorkCompetenceInterface $WorkCompetence
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(WorkCompetenceInterface $WorkCompetence, array $params);

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
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @return mixed
     */
    public function workCompetenceList(int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @param bool $count
     * @return mixed
     */
    public function workCompetenceListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $competenceId
     * @param object|null $rangeIssueDate
     * @param bool $count
     * @return mixed
     */
    public function workCompetencePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $competenceId = null, object $rangeIssueDate = null, bool $count = false);

    //</editor-fold>
}
