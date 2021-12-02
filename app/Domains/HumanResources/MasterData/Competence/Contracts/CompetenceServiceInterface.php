<?php

namespace App\Domains\HumanResources\MasterData\Competence\Contracts;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface CompetenceServiceInterface.
 */
interface CompetenceServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CompetenceServiceInterface constructor.
     *
     * @param CompetenceRepositoryInterface $repository
     */
    public function __construct(CompetenceRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Competence.
     *
     * @param CompetenceInterface $Competence
     *
     * @return mixed
     */
    public function create(CompetenceInterface $Competence);

    /**
     * Update Competence.
     *
     * @param CompetenceInterface $Competence
     *
     * @return mixed
     */
    public function update(CompetenceInterface $Competence);

    /**
     * Delete Competence.
     *
     * @param CompetenceInterface $Competence
     *
     * @return mixed
     */
    public function delete(CompetenceInterface $Competence);

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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function competenceList(int $companyId = null, int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function competenceListSearch(ListSearchRequest $request, int $companyId = null, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $companyId
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function competencePageSearch(PageSearchRequest $request, int $companyId = null, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param CompetenceInterface $Competence
     * @return mixed
     */
    public function competenceSetActive(CompetenceInterface $Competence): BasicResponse;

    /**
     * @param CompetenceInterface $Competence
     * @return ObjectResponse
     */
    public function competenceSlug(CompetenceInterface $Competence): ObjectResponse;

    //</editor-fold>
}
