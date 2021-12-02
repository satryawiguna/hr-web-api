<?php

namespace App\Domains\Commons\Access\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Access\Contracts\Request\CreateAccessRequest;
use App\Domains\Commons\Access\Contracts\Request\EditAccessActiveRequest;
use App\Domains\Commons\Access\Contracts\Request\EditAccessRequest;

/**
 * Interface AccessServiceInterface.
 */
interface AccessServiceInterface
{
    /**
     * AccessServiceInterface constructor.
     *
     * @param AccessRepositoryInterface $repository
     */
    public function __construct(AccessRepositoryInterface $repository);

    /**
     * Create Access.
     *
     * @param CreateAccessRequest $request
     *
     * @return mixed
     */
    public function create(CreateAccessRequest $request): ObjectResponse;

    /**
     * Update Access.
     *
     * @param EditAccessRequest $request
     *
     * @return mixed
     */
    public function update(EditAccessRequest $request): ObjectResponse;

    /**
     * Delete Access.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id): BasicResponse;

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids): BasicResponse;

    /**
     * @param EditAccessActiveRequest $request
     * @return BasicResponse
     */
    public function accessSetActive(EditAccessActiveRequest $request): BasicResponse;

    /**
     * @param string $name
     * @return ObjectResponse
     */
    public function accessSlug(string $name): ObjectResponse;

    /**
     * @param int|null $isActive
     * @return GenericCollectionResponse
     */
    public function accessList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function accessListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function accessPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;
}
