<?php

namespace App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\NonFormalEducationHistory\Contracts\EloquentNonFormalEducationHistoryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface NonFormalEducationHistoryRepositoryInterface.
 */
interface NonFormalEducationHistoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * NonFormalEducationHistoryRepositoryInterface constructor.
     *
     * @param EloquentNonFormalEducationHistoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentNonFormalEducationHistoryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create NonFormalEducationHistory.
     *
     * @param NonFormalEducationHistoryInterface $NonFormalEducationHistory
     *
     * @return mixed
     */
    public function create(NonFormalEducationHistoryInterface $NonFormalEducationHistory);

    /**
     * @param Collection $NonFormalEducationHistories
     * @return mixed
     */
    public function insert(Collection $NonFormalEducationHistories);

    /**
     * Update NonFormalEducationHistory.
     *
     * @param NonFormalEducationHistoryInterface $NonFormalEducationHistory
     *
     * @return mixed
     */
    public function update(NonFormalEducationHistoryInterface $NonFormalEducationHistory);

    /**
     * @param NonFormalEducationHistoryInterface $NonFormalEducationHistory
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(NonFormalEducationHistoryInterface $NonFormalEducationHistory, array $params);

    /**
     * Delete NonFormalEducationHistory.
     *
     * @param NonFormalEducationHistoryInterface $NonFormalEducationHistory
     *
     * @return mixed
     */
    public function delete(NonFormalEducationHistoryInterface $NonFormalEducationHistory);

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids);

    /**
     * Get CompanySize.
     *
     * @param $id
     *
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function nonFormalEducationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function nonFormalEducationHistoryListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function nonFormalEducationHistoryPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
