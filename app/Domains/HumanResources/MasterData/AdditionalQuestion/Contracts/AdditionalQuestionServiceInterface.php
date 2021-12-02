<?php

namespace App\Domains\HumanResources\MasterData\AdditionalQuestion\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface AdditionalQuestionServiceInterface.
 */
interface AdditionalQuestionServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * AdditionalQuestionServiceInterface constructor.
     *
     * @param AdditionalQuestionRepositoryInterface $repository
     */
    public function __construct(AdditionalQuestionRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">
    
    /**
     * Create AdditionalQuestion.
     *
     * @param AdditionalQuestionInterface $AdditionalQuestion
     *
     * @return mixed
     */
    public function create(AdditionalQuestionInterface $AdditionalQuestion);

    /**
     * Update AdditionalQuestion.
     *
     * @param AdditionalQuestionInterface $AdditionalQuestion
     *
     * @return mixed
     */
    public function update(AdditionalQuestionInterface $AdditionalQuestion);

    /**
     * Delete AdditionalQuestion.
     *
     * @param AdditionalQuestionInterface $AdditionalQuestion
     *
     * @return mixed
     */
    public function delete(AdditionalQuestionInterface $AdditionalQuestion);

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
     * @param int|null $isRequired
     * @param string|null $status
     * @return mixed
     */
    public function additionalQuestionList(int $companyId = null, int $isRequired = null, string $status = null);

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @return GenericListSearchResponse
     */
    public function additionalQuestionListSearch(ListSearchRequest $request, int $companyId = null, int $isRequired = null, string $status = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isRequired
     * @param string|null $status
     * @return GenericPageSearchResponse
     */
    public function additionalQuestionPageSearch(PageSearchRequest $request, int $companyId = null, int $isRequired = null, string $status = null): GenericPageSearchResponse;

    //</editor-fold>
}
