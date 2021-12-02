<?php

namespace App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\EloquentFormalEducationHistoryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface FormalEducationHistoryRepositoryInterface.
 */
interface FormalEducationHistoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormalEducationHistoryRepositoryInterface constructor.
     *
     * @param EloquentFormalEducationHistoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentFormalEducationHistoryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create FormalEducationHistory.
     *
     * @param FormalEducationHistoryInterface $FormalEducationHistory
     *
     * @return mixed
     */
    public function create(FormalEducationHistoryInterface $FormalEducationHistory);

    /**
     * @param Collection $FormalEducationHistories
     * @return mixed
     */
    public function insert(Collection $FormalEducationHistories);

    /**
     * Update FormalEducationHistory.
     *
     * @param FormalEducationHistoryInterface $FormalEducationHistory
     *
     * @return mixed
     */
    public function update(FormalEducationHistoryInterface $FormalEducationHistory);

    /**
     * @param FormalEducationHistoryInterface $FormalEducationHistory
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(FormalEducationHistoryInterface $FormalEducationHistory, array $params);

    /**
     * Delete FormalEducationHistory.
     *
     * @param FormalEducationHistoryInterface $FormalEducationHistory
     *
     * @return mixed
     */
    public function delete(FormalEducationHistoryInterface $FormalEducationHistory);

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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return mixed
     */
    public function formalEducationHistoryList(int $companyId =  null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function formalEducationHistoryListSearch(ListedSearchParameter $parameter, int $companyId =  null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function formalEducationHistoryPageSearch(PagedSearchParameter $parameter, int $companyId =  null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
