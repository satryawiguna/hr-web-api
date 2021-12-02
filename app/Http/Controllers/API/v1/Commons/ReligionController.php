<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Religion\Contracts\ReligionServiceInterface;
use App\Exports\Commons\ReligionExport;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ReligionController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_religionServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * UserController constructor.
     * @param ReligionServiceInterface $religionServiceInterface
     */
    public function __construct(ReligionServiceInterface $religionServiceInterface)
    {
        $this->_religionServiceInterface = $religionServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/religion/list",
     *     operationId="getReligionList",
     *     summary="Get list of religion",
     *     tags={"Religion"},
     *     description="Get list of religion",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="is_active",
     *          in="query",
     *          description="Is active parameter (active = 1; not active = 0)",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int32",
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
    public function getReligionList(Request $request)
    {
        $isActive = $request->get('is_active');

        return $this->getListJson($isActive,
            [$this->_religionServiceInterface, 'religionList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/religion/list-search",
     *     operationId="postReligionListSearch",
     *     summary="Get list of religion with query search",
     *     tags={"Religion"},
     *     description="Get list of religion with query search",
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
     *                      description="Query property (Keyword would be filter name, slug and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/ReligionEloquent/properties/is_active")
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
    public function postReligionListSearch(Request $request)
    {
        $isActive = $request->input('is_active');

        return $this->getListSearchJson($request, $isActive,
            [$this->_religionServiceInterface, 'religionListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/religion/page-search",
     *     operationId="postReligionPageSearch",
     *     summary="Get list of religion with query and page parameter search",
     *     tags={"Religion"},
     *     description="Get list of religion with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter name, slug and description)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="is_active", ref="#/components/schemas/ReligionEloquent/properties/is_active")
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
    public function postReligionPageSearch(Request $request)
    {
        $isActive = $request->input('is_active');

        return $this->getPagedSearchJson($request, $isActive,
            [$this->_religionServiceInterface, 'religionPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/religion/detail/{id}",
     *     operationId="getReligionDetail",
     *     summary="Get detail religion",
     *     tags={"Religion"},
     *     description="Get detail religion",
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
     *              type="integer",
     *              format="int64",
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReligionDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_religionServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'description' => $entity->description,
                        'is_active' => $entity->is_active,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/religion/create",
     *     operationId="postReligionCreate",
     *     summary="Create religion",
     *     tags={"Religion"},
     *     description="Create religion",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateReligionEloquent")
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
    public function postReligionCreate(Request $request)
    {
        $religion = $this->_religionServiceInterface->newInstance();

        $religion->name = $request->input('name');
        $religion->slug = $request->input('slug');
        $religion->description = $request->input('description');

        $this->setRequestAuthor($religion);

        $response = $this->_religionServiceInterface->create($religion);
        $religionCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $religionCreated);
    }

    /**
     * @OA\Put(
     *     path="/religion/update",
     *     operationId="putReligionUpdate",
     *     summary="Update religion",
     *     tags={"Religion"},
     *     description="Update religion",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateReligionEloquent")
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
    public function putReligionUpdate(Request $request)
    {
        $religion = $this->_religionServiceInterface->find($request->input('id'));

        $result = $religion->getObject();

        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->description = $request->input('description');

        $this->setRequestAuthor($result);

        $response = $this->_religionServiceInterface->update($result);
        $religionUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $religionUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/religion/delete/{id}",
     *     operationId="deleteReligion",
     *     summary="Delete religion",
     *     tags={"Religion"},
     *     description="Delete religion",
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
     *              type="integer",
     *              format="int64",
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteReligion(int $id)
    {
        $religion = $this->_religionServiceInterface->find($id);

        $result = $religion->getObject();

        $response = $this->_religionServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/religion/deletes",
     *     operationId="deleteBulkReligion",
     *     summary="Delete bulk religion",
     *     tags={"Religion"},
     *     description="Delete bulk religion",
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
     *                      property="ids",
     *                      description="Ids property",
     *                      type="array",
     *                      @OA\Items(
     *                          type="integer",
     *                          format="int64",
     *                          example=1
     *                      )
     *                  )
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
     * @return ObjectResponse|\Illuminate\Http\JsonResponse|mixed
     */
    public function deleteBulkReligion(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_religionServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Put(
     *     path="/religion/active",
     *     operationId="putReligionActive",
     *     summary="Set active religion",
     *     tags={"Religion"},
     *     description="Set active religion",
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
     *                       property="id",
     *                       type="integer",
     *                       format="int64",
     *                       description="Id property",
     *                       example=1
     *                  ),
     *                  @OA\Property(property="is_active", ref="#/components/schemas/ReligionEloquent/properties/is_active"),
     *                  required={
     *                      "id",
     *                      "is_active"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function putReligionActive(Request $request)
    {
        $religion = $this->_religionServiceInterface->find($request->input('id'));

        $result = $religion->getObject();

        $result->is_active = $request->input('is_active');

        $this->setRequestAuthor($result);

        $response = $this->_religionServiceInterface->religionSetActive($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/religion/slug/{name}",
     *     operationId="getReligionSlug",
     *     summary="Get slug of religion",
     *     tags={"Religion"},
     *     description="Return slug of religion",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name of religion",
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
     * Return slug of religion
     * 
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReligionSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_religionServiceInterface, 'religionSlug'],
            function ($entity) {
                $rowJsonData = new Collection();

                $rowJsonData->push([
                    'slug' => $entity->slug
                ]);

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/religion/list-search/export",
     *     operationId="postReligionListSearchExport",
     *     summary="Get list export of bank",
     *     tags={"Religion"},
     *     description="Return bank exported",
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
     *                      property="export",
     *                      description="Export property",
     *                      type="string",
     *                      enum={"excel", "pdf"},
     *                      default="",
     *                      example="excel"
     *                  ),
     *                  @OA\Property(
     *                      property="is_active",
     *                      description="Filter is_active of bank by is_active parameter. 1 for active and 0 for not active",
     *                      type="integer",
     *                      format="int32"
     *                  )
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postReligionListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $isActive = $request->input('is_active');

        return $this->getListSearchExportJson($request, $export, $isActive,
            [$this->_religionServiceInterface, 'religionListSearch'],
            function (Collection $entities, string $export) {
                switch ($export) {
                    case 'excel':
                        $ext = '.xlsx';

                        return self::generateExcel($entities, $ext);

                        break;

                    case 'pdf':
                        $ext = '.pdf';

                        return self::generatePDF($entities, $ext);

                        break;

                    default:
                        //Do nothing
                        break;
                }
            });

    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

    /**
     * @param Collection $entities
     * @param string|null $ext
     * @return mixed
     */
    private function generateExcel(Collection $entities, string $ext = null) {
        $response = new BooleanResponse();

        $path = 'public/';
        $file = uniqid() . $ext;

        if (Excel::store(new ReligionExport($entities), $path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Invalid file generate', 400);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, [
            'result' => $response->getBoolean(),
            'file' => $file
        ])->getData();
    }

    /**
     * @param Collection $entities
     * @param string|null $ext
     * @return mixed
     */
    private function generatePDF(Collection $entities, string $ext = null) {
        $response = new BooleanResponse();

        $path = 'storage/';
        $file = uniqid() . $ext;

        if (PDF::loadView('exports.commons.religion', ['religions' => $entities])
            ->setPaper('a4', 'landscape')
            ->save($path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Invalid file generate', 400);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, [
            'result' => $response->getBoolean(),
            'file' =>  $file
        ])->getData();
    }

    /**
     * @param int $id
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getDetailObjectJson(int $id,
                                         callable $searchMethod,
                                         callable $dtoObjectToJsonMethod)
    {
        $response = $searchMethod($id);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param string $name
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getSlugObjectJson(string $name,
                                       callable $searchMethod,
                                       callable $dtoObjectToJsonMethod)
    {
        $religion = $this->_religionServiceInterface->newInstance();
        $religion->name = $name;

        $response = $searchMethod($religion);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $isActive = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($isActive);
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
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $isActive = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $isActive);
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
     * @param string|null $export
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $isActive = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $isActive);
        $rowJsonData = $dtoObjectToJsonMethod($response->getDtoCollection(), $export);

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
     * @param int|null $isActive
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $isActive = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $isActive);
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

    //</editor-fold>
}
