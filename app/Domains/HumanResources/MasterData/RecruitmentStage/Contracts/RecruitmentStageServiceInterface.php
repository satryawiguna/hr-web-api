<?php

namespace App\Domains\HumanResources\MasterData\RecruitmentStage\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface RecruitmentStageServiceInterface.
 */
interface RecruitmentStageServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RecruitmentStageServiceInterface constructor.
     *
     * @param RecruitmentStageRepositoryInterface $repository
     */
    public function __construct(RecruitmentStageRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create RecruitmentStage.
     *
     * @param RecruitmentStageInterface $RecruitmentStage
     *
     * @return mixed
     */
    public function create(RecruitmentStageInterface $RecruitmentStage);

    /**
     * Update RecruitmentStage.
     *
     * @param RecruitmentStageInterface $RecruitmentStage
     *
     * @return mixed
     */
    public function update(RecruitmentStageInterface $RecruitmentStage);

    /**
     * Delete RecruitmentStage.
     *
     * @param RecruitmentStageInterface $RecruitmentStage
     *
     * @return mixed
     */
    public function delete(RecruitmentStageInterface $RecruitmentStage);

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
     * @return GenericCollectionResponse
     */
    public function recruitmentStageList(int $companyId = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @return GenericListSearchResponse
     */
    public function recruitmentStageListSearch(ListSearchRequest $request, int $companyId = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @return GenericPageSearchResponse
     */
    public function recruitmentStagePageSearch(PageSearchRequest $request, int $companyId = null): GenericPageSearchResponse;

    /**
     * @param RecruitmentStageInterface $RecruitmentStage
     * @return ObjectResponse
     */
    public function recruitmentStageSlug(RecruitmentStageInterface $RecruitmentStage): ObjectResponse;

    //</editor-fold>
}
