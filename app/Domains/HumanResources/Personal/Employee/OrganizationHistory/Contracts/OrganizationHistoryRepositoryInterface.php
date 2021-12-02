<?php

namespace App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OrganizationHistory\Contracts\EloquentOrganizationHistoryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface OrganizationHistoryRepositoryInterface.
 */
interface OrganizationHistoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OrganizationHistoryRepositoryInterface constructor.
     *
     * @param EloquentOrganizationHistoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentOrganizationHistoryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create OrganizationHistory.
     *
     * @param OrganizationHistoryInterface $OrganizationHistory
     *
     * @return mixed
     */
    public function create(OrganizationHistoryInterface $OrganizationHistory);

    /**
     * @param Collection $OrganizationHistories
     * @return mixed
     */
    public function insert(Collection $OrganizationHistories);

    /**
     * Update OrganizationHistory.
     *
     * @param OrganizationHistoryInterface $OrganizationHistory
     *
     * @return mixed
     */
    public function update(OrganizationHistoryInterface $OrganizationHistory);

    /**
     * @param OrganizationHistoryInterface $OrganizationHistory
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(OrganizationHistoryInterface $OrganizationHistory, array $params);

    /**
     * Delete OrganizationHistory.
     *
     * @param OrganizationHistoryInterface $OrganizationHistory
     *
     * @return mixed
     */
    public function delete(OrganizationHistoryInterface $OrganizationHistory);

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
     * @param DateTime|null $date
     * @return mixed
     */
    public function organizationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function organizationHistoryListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function organizationHistoryPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, DateTime $date = null, bool $count = false);

    //</editor-fold>
}
