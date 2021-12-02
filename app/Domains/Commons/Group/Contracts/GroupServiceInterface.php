<?php
namespace App\Domains\Commons\Group\Contracts;


use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;

/**
 * Interface GroupServiceInterface.
 */
interface GroupServiceInterface
{
    /**
     * GroupServiceInterface constructor.
     *
     * @param GroupRepositoryInterface $repository
     */
    public function __construct(GroupRepositoryInterface $repository);

    /**
     * Create Group.
     *
     * @param GroupInterface $Group
     *
     * @return mixed
     */
    public function create(GroupInterface $Group);

    /**
     * Update Group.
     *
     * @param GroupInterface $Group
     *
     * @return mixed
     */
    public function update(GroupInterface $Group);

    /**
     * Delete Group.
     *
     * @param GroupInterface $Group
     *
     * @return mixed
     */
    public function delete(GroupInterface $Group);

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
    public function groupList(int $isActive = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param int|null $isActive
     * @return GenericListSearchResponse
     */
    public function groupListSearch(ListSearchRequest $request, int $isActive = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param int|null $isActive
     * @return GenericPageSearchResponse
     */
    public function groupPageSearch(PageSearchRequest $request, int $isActive = null): GenericPageSearchResponse;

    /**
     * @param GroupInterface $Group
     * @return BasicResponse
     */
    public function groupSetActive(GroupInterface $Group): BasicResponse;

    /**
     * @param GroupInterface $Group
     * @return ObjectResponse
     */
    public function groupSlug(GroupInterface $Group): ObjectResponse;

    //</editor-fold>
}
