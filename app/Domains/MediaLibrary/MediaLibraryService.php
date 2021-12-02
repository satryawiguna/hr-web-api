<?php

namespace App\Domains\MediaLibrary;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\CompanyRepository;
use App\Domains\Commons\Company\Contracts\CompanyRepositoryInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryInterface;
use App\Domains\ServiceAbstract;
use App\Domains\MediaLibrary\Contracts\MediaLibraryRepositoryInterface;
use App\Domains\MediaLibrary\Contracts\MediaLibraryServiceInterface;
use App\Domains\User\Contracts\UserRepositoryInterface;
use App\Helpers\MediaFolder;
use ErrorException;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * MediaLibraryService Class
 * It has all useful methods for business logic.
 */
class MediaLibraryService extends ServiceAbstract implements MediaLibraryServiceInterface
{
    /**
     * @var MediaLibraryRepositoryInterface
     */
    protected $repository;
    protected $userRepository;

    /**
     * Loads our $repo with the actual Repo associated with our MediaLibraryInterface
     * MediaLibraryService constructor.
     *
     * @param MediaLibraryRepositoryInterface $repository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(MediaLibraryRepositoryInterface $repository,
                                UserRepositoryInterface $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $id
     * @return ObjectResponse
     */
    public function findMedia(string $id): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $result = $this->repository()->findWhere([
                ['id', '=', $id]
            ])->first();

            $response->setResult($result);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int $userId
     * @param string $collection
     * @param UploadedFile $file
     * @return ObjectResponse
     */
    public function uploadFile(int $userId, string $collection, UploadedFile $file): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            $media = [
                'user_id' => $userId,
                'collection' => $collection,
                'original_file' => $file->getClientOriginalName(),
                'generate_file' => Carbon::now()->timestamp . '_' . uniqid() . '.' . $file->getClientOriginalExtension(),
                'extension' => $file->getClientOriginalExtension(),
                'type' => MediaFolder::getFileType($file->getClientOriginalExtension()),
                'mime_type' => $file->getMimeType(),
                'disk' => 'storage',
                'path' => constant('App\Helpers\MediaFolder::'. $collection),
                'size' => $file->getSize()
            ];

            //File upload
            $dimension = Config::get('image.' . strtolower($collection) . '.dimension');
            $medias = new Collection();

            if (!is_null($dimension)) {
                $media['width'] = Image::make($file)->width();
                $media['height'] = Image::make($file)->height();

                Image::make($file)->save($media['path'] . '/' . $media['generate_file']);
                $medias->push($media['path'] . '/' . $media['generate_file']);

                foreach ($dimension as $row) {
                    $canvas = Image::canvas($row['width'], $row['height']);
                    $resizeImage  = Image::make($file)->resize($row['width'], $row['height'], function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $canvas->insert($resizeImage, 'center');

                    $thumb = explode('.', $media['generate_file']);

                    $canvas->save($media['path'] . '/' . $thumb[0] . '_' . $row['width'] . 'x' . $row['height'] . '.' . $thumb[1]);
                    $medias->push($media['path'] . '/' . $thumb[0] . '_' . $row['width'] . 'x' . $row['height'] . '.' . $thumb[1]);
                }
            } else {
                $file->move($media['path'], $media['generate_file']);
                $medias->push($media['path'] . '/' . $media['generate_file']);
            }

            //Create
            $mediaLibrary = $this->newInstance($media);

            $this->setAuditableInformationFromRequest($mediaLibrary);

            try {
                $result = $this->repository->create($mediaLibrary);

                $response->setResult($result);
                $response->addSuccessMessageResponse($response->getMessageCollection(), 'File success uploaded', 200);
            } catch (Exception $ex) {
                $this->fileUploadRollBack($medias);

                if (method_exists($ex,'getResponse')) {
                    $exception = new ErrorException((string) $ex->getResponse()->getBody());
                    $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
                }

                $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
            }

        } catch (\Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param MediaLibraryInterface $MediaLibrary
     * @return ObjectResponse
     */
    public function removeFile(MediaLibraryInterface $MediaLibrary): ObjectResponse
    {
        $response = new ObjectResponse();

        try {
            //File remove
            if (!is_null($MediaLibrary->getWidth()) &&
                !is_null($MediaLibrary->getHeight())) {
                $dimension = Config::get('image.' . strtolower($MediaLibrary->getCollection()) . '.dimension');

                if(!is_null($dimension)){
                    foreach ($dimension as $row) {
                        $thumb = explode('.', $MediaLibrary->getGenerateFile());

                        File::delete($MediaLibrary->getPath() . '/' . $thumb[0] . '_' . $row['width'] . 'x' . $row['height'] . '.' . $thumb[1]);
                    }
                }
            }
            
            if(File::exists($MediaLibrary->getPath() . '/' . $MediaLibrary->getGenerateFile()))
                File::delete($MediaLibrary->getPath() . '/' . $MediaLibrary->getGenerateFile());

            $this->repository->delete($MediaLibrary);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Media library was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @return GenericCollectionResponse
     */
    public function mediaLibraryList(int $userId, int $companyId = null, string $collection = null): GenericCollectionResponse
    {
        $response = new GenericCollectionResponse();

        try {
            if (!is_null($companyId)) {
                $userIds = $this->userRepository->findUserWhereHasCompany($companyId)
                    ->toArray();
            } else {
                $userIds = [$userId];
            }

            $results = $this->repository->mediaLibraryList($userIds, $collection);

            $response->setDtoList($results);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param ListSearchRequest $listSearchRequest
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @return GenericListSearchResponse
     */
    public function mediaLibraryListSearch(ListSearchRequest $listSearchRequest, int $userId, int $companyId = null, string $collection = null): GenericListSearchResponse
    {
        $response = new GenericListSearchResponse();

        $parameter = new ListedSearchParameter();

        try {
            $parameter->query = $listSearchRequest->query;

            if (!is_null($companyId)) {
                $userIds = $this->userRepository->findUserWhereHasCompany($companyId)
                    ->toArray();
            } else {
                $userIds = [$userId];
            }

            $results = $this->repository->mediaLibraryListSearch($parameter, $userIds, $collection);
            $totalCount = $this->repository->mediaLibraryListSearch($parameter, $userIds, $collection, true);

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    /**
     * @param PageSearchRequest $pageSearchRequest
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @return GenericPageSearchResponse
     */
    public function mediaLibraryPageSearch(PageSearchRequest $pageSearchRequest, int $userId, int $companyId = null, string $collection = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            if (!is_null($companyId)) {
                $userIds = $this->userRepository->findUserWhereHasCompany($companyId)
                    ->toArray();
            } else {
                $userIds = [$userId];
            }

            $results = $this->repository->mediaLibraryPageSearch($parameter, $userIds, $collection);
            $totalCount = $this->repository->mediaLibraryPageSearch($parameter, $userIds, $collection, true);

            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }


    /**
     * @param Collection|null $files
     */
    private function fileUploadRollBack(Collection $files = null): void
    {
        if (!is_null($files)) {
            foreach ($files as $file) {
                File::delete($file);
            }
        }
    }
}
