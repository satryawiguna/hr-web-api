<?php
namespace App\Http\Controllers\API\v1;


use App\Domains\MediaLibrary\Contracts\MediaLibraryServiceInterface;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

class MediaController extends Controller
{
    use BaseController;

    private $_mediaLibraryServiceInterface;

    /**
     * MediaController constructor.
     * @param MediaLibraryServiceInterface $mediaLibraryServiceInterface
     */
    public function __construct(MediaLibraryServiceInterface $mediaLibraryServiceInterface)
    {
        $this->_mediaLibraryServiceInterface = $mediaLibraryServiceInterface;
    }

    /**
     * @OA\Get(
     *     path="/media/list",
     *     operationId="getMediaLibraryList",
     *     summary="Get list of media library",
     *     tags={"Media Library"},
     *     description="Get list of media library",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          description="User id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="company_id",
     *          in="query",
     *          description="Company id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="collection",
     *          in="query",
     *          description="collection parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"STORAGE", "COMPANY", "PROFILE", "EMPLOYEE", "PROJECT", "PROJECT_ADDENDUM"},
     *              example=1
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMediaLibraryList(Request $request)
    {
        $userId = $request->get('user_id');
        $companyId = $request->get('company_id');
        $collection = $request->input('collection');

        return $this->getListJson($userId, $companyId, $collection,
            [$this->_mediaLibraryServiceInterface, 'mediaLibraryList'],
            function(Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'collection' => $entity->collection,
                        'original_file' => $entity->original_file,
                        'generate_file' => $entity->generate_file,
                        'extension' => $entity->extension,
                        'type' => $entity->type,
                        'mime_type' => $entity->mime_type,
                        'disk' => $entity->disk,
                        'path' => $entity->path,
                        'width' => $entity->width,
                        'height' => $entity->height,
                        'size' => $entity->size,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/media/list-search",
     *     operationId="postMediaLibraryListSearch",
     *     summary="Get list of media library with query search",
     *     tags={"Media Library"},
     *     description="Get list of media library with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter original file)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="user_id", ref="#/components/schemas/MediaLibraryEloquent/properties/user_id"),
     *                  @OA\Property(
     *                      property="company_id",
     *                      description="Company id property",
     *                      type="integer",
     *                      format="int64",
     *                      example="1"
     *                  ),
     *                  @OA\Property(property="collection", ref="#/components/schemas/MediaLibraryEloquent/properties/collection")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMediaLibraryListSearch(Request $request)
    {
        $userId = $request->input('user_id');
        $companyId = $request->input('company_id');
        $collection = $request->input('collection');

        return $this->getListSearchJson($request, $userId, $companyId, $collection,
            [$this->_mediaLibraryServiceInterface, 'mediaLibraryListSearch'],
            function(Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'collection' => $entity->collection,
                        'original_file' => $entity->original_file,
                        'generate_file' => $entity->generate_file,
                        'extension' => $entity->extension,
                        'type' => $entity->type,
                        'mime_type' => $entity->mime_type,
                        'disk' => $entity->disk,
                        'path' => $entity->path,
                        'width' => $entity->width,
                        'height' => $entity->height,
                        'size' => $entity->size,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/media/page-search",
     *     operationId="postMediaLibraryPageSearch",
     *     summary="Get list of media library with query and page parameter search",
     *     tags={"Media Library"},
     *     description="Get list of media library with query and page parameter search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="query",
     *                              description="Query property (Keyword would be filter file original)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="user_id", ref="#/components/schemas/MediaLibraryEloquent/properties/user_id"),
     *                          @OA\Property(
     *                              property="company_id",
     *                              description="Company id property",
     *                              type="integer",
     *                              format="int64",
     *                              example="1"
     *                          ),
     *                          @OA\Property(property="collection", ref="#/components/schemas/MediaLibraryEloquent/properties/collection")
     *                      ),
     *                      @OA\Schema(ref="#/components/schemas/PagedSearchParameter")
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return mixed
     */
    public function postMediaLibraryPageSearch(Request $request)
    {
        $userId = $request->input('user_id');
        $companyId = $request->input('company_id');
        $collection = $request->input('collection');

        return $this->getPagedSearchJson($request, $userId, $companyId, $collection,
            [$this->_mediaLibraryServiceInterface, 'mediaLibraryPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'collection' => $entity->collection,
                        'original_file' => $entity->original_file,
                        'generate_file' => $entity->generate_file,
                        'extension' => $entity->extension,
                        'type' => $entity->type,
                        'mime_type' => $entity->mime_type,
                        'disk' => $entity->disk,
                        'path' => $entity->path,
                        'width' => $entity->width,
                        'height' => $entity->height,
                        'size' => $entity->size,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/file/upload",
     *     operationId="postUploadFile",
     *     summary="Upload file",
     *     tags={"Media Library"},
     *     description="Return info of file uploaded",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  allOf={
     *                      @OA\Schema(ref="#/components/schemas/UploadFileMediaLibraryEloquent"),
     *                      @OA\Schema(
     *                          @OA\Property(
     *                              property="file",
     *                              description="File property",
     *                              type="file",
     *                              format="file",
     *                          ),
     *                      )
     *                  }
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function postUploadFile(Request $request) {
        $userId = $request->input('user_id');
        $collection = $request->input('collection');

        /** @var UploadedFile $file */
        $file = $request->file('file');

        $response = $this->_mediaLibraryServiceInterface->uploadFile($userId, $collection, $file);
        $mediaUploaded = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $mediaUploaded);
    }

    /**
     * @OA\Get(
     *     path="/file/download",
     *     operationId="getDownloadFile",
     *     summary="Download file",
     *     tags={"Media Library"},
     *     description="Return info of file downloaded",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="collection",
     *          in="query",
     *          description="Collection property",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              enum={"STORAGE", "COMPANY", "PROFILE", "EMPLOYEE", "PROJECT", "PROJECT_ADDENDUM"},
     *              default=""
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="file",
     *          in="query",
     *          description="File property",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="action",
     *          in="query",
     *          description="Action of download",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              enum={"DELETE"},
     *              default=""
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function getDownloadFile(Request $request)
    {
        $collection = $request->get('collection');
        $file = $request->get('file');
        $action = $request->get('action');

        if ($action && ($action == 'DELETE' || $action == 'delete')) {
            return response()->download(constant('App\Helpers\MediaFolder::' . $collection) . '/' . $file)
                ->deleteFileAfterSend(true);
        } else {
            return response()->download(constant('App\Helpers\MediaFolder::' . $collection) . '/' . $file);
        }
    }

    /**
     * @OA\Delete(
     *     path="/file/delete/{id}",
     *     operationId="deleteRemoveFile",
     *     summary="Delete media library",
     *     tags={"Media Library"},
     *     description="Return object of media library deleted",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id parameter",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=400,
     *          description="Bad request",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRemoveFile(string $id)
    {
        $mediaLibrary = $this->_mediaLibraryServiceInterface->findMedia($id);

        $result = $mediaLibrary->getObject();

        $response = $this->_mediaLibraryServiceInterface->removeFile($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }


    /**
     * @param int $userId
     * @param int|null $companyId
     * @param string $collection
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $userId, int $companyId = null, string $collection = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($userId, $companyId, $collection);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData
            ]);
        }

        return $this->getBasicErrorJson($response);
    }


    /**
     * @param Request $request
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $userId, int $companyId = null, string $collection = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $userId, $companyId, $collection);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            return response()->json([
                'rows' => $rowJsonData,
                'rowCountTotal' => $response->getTotalCount()
            ]);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param Request $request
     * @param int $userId
     * @param int|null $companyId
     * @param string|null $collection
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $userId, int $companyId = null,  string $collection = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $userId, $companyId, $collection);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection());

        if ($response->isSuccess()) {
            if ($parameter->draw) {
                return response()->json([
                    'rows' => $rowJsonData,
                    'rowCountPage' => $response->getTotalPage(),
                    'rowCountTotal' => $response->getTotalCount()
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'page' => (integer)$parameter->pagination['page'],
                        'pages' => $response->getTotalPage(),
                        'perpage' => (integer)$parameter->pagination['perpage'],
                        'total' => $response->getTotalCount(),
                        'sort' => $parameter->sort['sort'],
                        'field' => $parameter->sort['field']
                    ],
                    'rows' => $rowJsonData
                ]);
            }
        }

        return $this->getBasicErrorJson($response);
    }
}
