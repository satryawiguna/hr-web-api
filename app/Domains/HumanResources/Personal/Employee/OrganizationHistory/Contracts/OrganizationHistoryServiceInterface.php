<?php

namespace App\Domains\HumanResources\Personal\Employee\OrganizationHistory\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface OrganizationHistoryServiceInterface.
 */
interface OrganizationHistoryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OrganizationHistoryServiceInterface constructor.
     *
     * @param OrganizationHistoryRepositoryInterface $repository
     */
    public function __construct(OrganizationHistoryRepositoryInterface $repository);

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
     * @param array $params
     * @return mixed
     */
    public function update(OrganizationHistoryInterface $OrganizationHistory, array $params = []);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function organizationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function organizationHistoryListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function organizationHistoryPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
