<?php

namespace App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use DateTime;
use Illuminate\Support\Collection;

/**
 * Interface FormalEducationHistoryServiceInterface.
 */
interface FormalEducationHistoryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormalEducationHistoryServiceInterface constructor.
     *
     * @param FormalEducationHistoryRepositoryInterface $repository
     */
    public function __construct(FormalEducationHistoryRepositoryInterface $repository);

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
     * @param array $params
     * @return mixed
     */
    public function update(FormalEducationHistoryInterface $FormalEducationHistory, array $params = []);

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
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function formalEducationHistoryList(int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function formalEducationHistoryListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function formalEducationHistoryPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
