<?php

namespace App\Domains\Commons\Gender\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface GenderServiceInterface.
 */
interface GenderServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * GenderServiceInterface constructor.
     *
     * @param GenderRepositoryInterface $repository
     */
    public function __construct(GenderRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Gender.
     *
     * @param GenderInterface $Gender
     *
     * @return mixed
     */
    public function create(GenderInterface $Gender): ObjectResponse;

    /**
     * Update Gender.
     *
     * @param GenderInterface $Gender
     *
     * @return mixed
     */
    public function update(GenderInterface $Gender): BasicResponse;

    /**
     * Delete Gender.
     *
     * @param GenderInterface $Gender
     *
     * @return mixed
     */
    public function delete(GenderInterface $Gender): BasicResponse;

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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function genderList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function genderListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function genderPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param GenderInterface $Gender
     * @return mixed
     */
    public function genderSetActive(GenderInterface $Gender): BasicResponse;

    /**
     * @param GenderInterface $Gender
     * @return ObjectResponse
     */
    public function genderSlug(GenderInterface $Gender): ObjectResponse;

    //</editor-fold>
}
