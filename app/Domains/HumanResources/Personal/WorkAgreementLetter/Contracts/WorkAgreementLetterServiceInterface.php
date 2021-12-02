<?php

namespace App\Domains\WorkAgreementLetter\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request\CreateWorkAgreementLetterRequest;
use App\Domains\HumanResources\Personal\WorkAgreementLetter\Contracts\Request\EditWorkAgreementLetterRequest;
use DateTime;

/**
 * Interface WorkAgreementLetterServiceInterface.
 */
interface WorkAgreementLetterServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkAgreementLetterServiceInterface constructor.
     *
     * @param WorkAgreementLetterRepositoryInterface $repository
     */
    public function __construct(WorkAgreementLetterRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create WorkAgreementLetter.
     *
     * @param CreateWorkAgreementLetterRequest $request
     * @return mixed
     */
    public function create(CreateWorkAgreementLetterRequest $request): ObjectResponse;

    /**
     * Update WorkAgreementLetter.
     *
     * @param EditWorkAgreementLetterRequest $request
     * @return mixed
     */
    public function update(EditWorkAgreementLetterRequest $request): ObjectResponse;

    /**
     * Delete WorkAgreementLetter.
     *
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericCollectionResponse
     */
    public function workAgreementLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericListSearchResponse
     */
    public function workAgreementLetterListSearch(ListSearchRequest $request, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return GenericPageSearchResponse
     */
    public function workAgreementLetterPageSearch(PageSearchRequest $request, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null): GenericPageSearchResponse;

    //</editor-fold>
}
