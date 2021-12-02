<?php

namespace App\Domains\MediaLibrary\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Domains\User\Contracts\UserRepositoryInterface;
use FontLib\TrueType\Collection;
use Illuminate\Http\UploadedFile;

/**
 * Interface MediaLibraryServiceInterface.
 */
interface MediaLibraryServiceInterface
{
    /**
     * MediaLibraryServiceInterface constructor.
     *
     * @param MediaLibraryRepositoryInterface $repository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(MediaLibraryRepositoryInterface $repository,
                                UserRepositoryInterface $userRepository);

    /**
     * @param string $id
     * @return ObjectResponse
     */
    public function findMedia(string $id): ObjectResponse;

    /**
     * @param int $userId
     * @param string $collection
     * @param UploadedFile $file
     * @return ObjectResponse
     */
    public function uploadFile(int $userId, string $collection, UploadedFile $file): ObjectResponse;

    /**
     * @param MediaLibraryInterface $MediaLibrary
     * @return ObjectResponse
     */
    public function removeFile(MediaLibraryInterface $MediaLibrary): ObjectResponse;

    /**
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @return GenericCollectionResponse
     */
    public function mediaLibraryList(int $userId, int $companyId = null, string $collection = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @return GenericListSearchResponse
     */
    public function mediaLibraryListSearch(ListSearchRequest $listSearchRequest, int $userId, int $companyId = null,  string $collection = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @return GenericPageSearchResponse
     */
    public function mediaLibraryPageSearch(PageSearchRequest $pageSearchRequest, int $userId, int $companyId = null, string $collection = null): GenericPageSearchResponse;

}
