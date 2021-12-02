<?php

namespace App\Domains\HumanResources\Personal\Employee\NonFormalEducationHistory\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface NonFormalEducationHistoryServiceInterface.
 */
interface NonFormalEducationHistoryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * NonFormalEducationHistoryServiceInterface constructor.
     *
     * @param NonFormalEducationHistoryRepositoryInterface $repository
     */
    public function __construct(NonFormalEducationHistoryRepositoryInterface $repository);

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
     * @param array $params
     * @return mixed
     */
    public function update(NonFormalEducationHistoryInterface $NonFormalEducationHistory, array $params = []);

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
    public function nonFormalEducationHistoryList(int $companyId = null, int $employeeId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function nonFormalEducationHistoryListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function nonFormalEducationHistoryPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
