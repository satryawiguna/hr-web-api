<?php

namespace App\Domains\Commons\Application\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface ApplicationServiceInterface.
 */
interface ApplicationServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ApplicationServiceInterface constructor.
     *
     * @param ApplicationRepositoryInterface $repository
     */
    public function __construct(ApplicationRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Application.
     *
     * @param ApplicationInterface $Application
     *
     * @return mixed
     */
    public function create(ApplicationInterface $Application): ObjectResponse;

    /**
     * Update Application.
     *
     * @param ApplicationInterface $Application
     *
     * @return mixed
     */
    public function update(ApplicationInterface $Application): BasicResponse;

    /**
     * Delete Application.
     *
     * @param ApplicationInterface $Application
     *
     * @return mixed
     */
    public function delete(ApplicationInterface $Application): BasicResponse;

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
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function applicationList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function applicationListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function applicationPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param ApplicationInterface $Application
     * @return mixed
     */
    public function applicationSetActive(ApplicationInterface $Application): BasicResponse;

    /**
     * @param ApplicationInterface $Application
     * @return ObjectResponse
     */
    public function applicationSlug(ApplicationInterface $Application): ObjectResponse;
    
    //</editor-fold>
}
