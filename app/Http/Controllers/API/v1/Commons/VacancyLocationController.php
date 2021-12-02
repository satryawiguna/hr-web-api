<?php

namespace App\Http\Controllers\API\v1\Commons;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\VacancyLocation\Contracts\VacancyLocationInterface;
use App\Domains\Commons\VacancyLocation\Contracts\VacancyLocationServiceInterface;
use App\Exports\Commons\VacancyLocationExport;
use App\Helpers\Common;
use App\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class VacancyLocationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_vacancyLocationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * VacancyLocationController constructor.
     * @param VacancyLocationServiceInterface $vacancyLocationServiceInterface
     */
    public function __construct(VacancyLocationServiceInterface $vacancyLocationServiceInterface)
    {
        $this->_vacancyLocationServiceInterface = $vacancyLocationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/vacancy-locations",
     *     operationId="getVacancyLocationList",
     *     summary="Get list of vacancyLocation",
     *     tags={"VacancyLocation"},
     *     description="Get list of vacancyLocation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="parent_id",
     *          in="query",
     *          description="Parent id parameter",
     *          required=false,
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVacancyLocationList(Request $request)
    {
        $parentId = $request->get('parent_id');

        return $this->getListJson($parentId,
            [$this->_vacancyLocationServiceInterface, 'vacancyLocationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'country' => $entity->country
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy-locations/list-search",
     *     operationId="postVacancyLocationListSearch",
     *     summary="Get list of vacancyLocation with query search",
     *     tags={"VacancyLocation"},
     *     description="Get list of vacancyLocation with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="query",
     *                      description="Query property (Keyword would be filter name, slug and description)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="parent_id", ref="#/components/schemas/VacancyLocationEloquent/properties/parent_id")
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
    public function postVacancyLocationListSearch(Request $request)
    {
        $parentId = $request->get('parent_id');

        return $this->getListSearchJson($request, $parentId,
            [$this->_vacancyLocationServiceInterface, 'vacancyLocationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        '_lft' => $entity->_lft,
                        '_rgt' => $entity->_rgt
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy-locations/page-search",
     *     operationId="postVacancyLocationPageSearch",
     *     summary="Get list of vacancyLocation with query and page parameter search",
     *     tags={"VacancyLocation"},
     *     description="Get list of vacancyLocation with query and page parameter search",
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
     *                          )
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
    public function postVacancyLocationPageSearch(Request $request)
    {
        $parentId = $request->input('parent_id');

        return $this->getPagedSearchJson($request, $parentId,
            [$this->_vacancyLocationServiceInterface, 'vacancyLocationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'country' => $entity->country,
                        '_lft' => $entity->_lft,
                        '_rgt' => $entity->_rgt,
                        'parent_id' => Common::isDataExist($entity->vacancyLocationParent) ? $this->getVacancyLocationParentObject($entity->vacancyLocationParent) : null,
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/vacancy-location",
     *     operationId="postVacancyLocationCreate",
     *     summary="Create vacancyLocation",
     *     tags={"VacancyLocation"},
     *     description="Create vacancyLocation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateVacancyLocationEloquent")
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
    public function postVacancyLocationCreate(Request $request)
    {
        $vacancyLocation = $this->_vacancyLocationServiceInterface->newInstance();

        $vacancyLocation->name = $request->input('name');
        $vacancyLocation->slug = $request->input('slug');
        $vacancyLocation->country = $request->input('country');
        $vacancyLocation->_lft = $request->input('_lft') ? $request->input('_lft') : 0;
        $vacancyLocation->_rgt = $request->input('_rgt') ? $request->input('_rgt') : 0;
        $vacancyLocation->parent_id = $request->has('parent_id') && $request->parent_id != 0 ? $request->input('parent_id') : null;

        $response = $this->_vacancyLocationServiceInterface->create($vacancyLocation);
        $vacancyLocationCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyLocationCreated);
    }

    /**
     * @OA\Put(
     *     path="/vacancy-location",
     *     operationId="putVacancyLocationUpdate",
     *     summary="Update vacancyLocation",
     *     tags={"VacancyLocation"},
     *     description="Update vacancyLocation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateVacancyLocationEloquent")
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
    public function putVacancyLocationUpdate(Request $request)
    {
        $vacancyLocation = $this->_vacancyLocationServiceInterface->find($request->input('id'));

        $result = $vacancyLocation->getObject();

        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->country = $request->input('country');
        $vacancyLocation->_lft = $request->input('_lft') ? $request->input('_lft') : 0;
        $vacancyLocation->_rgt = $request->input('_rgt') ? $request->input('_rgt') : 0;
        $result->parent_id = $request->has('parent_id') && $request->parent_id != 0 ? $request->get('parent_id') : null;

        $this->setRequestAuthor($result);

        $response = $this->_vacancyLocationServiceInterface->update($result);
        $vacancyLocationUpdated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $vacancyLocationUpdated);
    }

    /**
     * @OA\Delete(
     *     path="/vacancy-Location/{id}",
     *     operationId="deleteVacancyLocation",
     *     summary="Delete vacancyLocation",
     *     tags={"VacancyLocation"},
     *     description="Delete vacancyLocation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id of vacancyLocation",
     *          required=true,
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteVacancyLocation(int $id)
    {
        $vacancyLocation = $this->_vacancyLocationServiceInterface->find($id);

        $result = $vacancyLocation->getObject();

        $response = $this->_vacancyLocationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/vacancy-locations",
     *     operationId="deleteBulkVacancyLocation",
     *     summary="Delete bulk vacancyLocation",
     *     tags={"VacancyLocation"},
     *     description="Delete bulk vacancyLocation",
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
    public function deleteBulkVacancyLocation(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_vacancyLocationServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/vacancy-Location/slug/{name}",
     *     operationId="getVacancyLocationSlug",
     *     summary="Get slug of vacancyLocation",
     *     tags={"VacancyLocation"},
     *     description="Get slug of vacancyLocation",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="name",
     *          in="path",
     *          description="Name parameter",
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
     * @param string $name
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVacancyLocationSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_vacancyLocationServiceInterface, 'vacancyLocationSlug'],
            function ($entity) {
                $rowJsonData = new Collection();

                $rowJsonData->push([
                    'slug' => $entity->slug
                ]);

                return $rowJsonData->first();
            });
    }

    //</editor-fold>


    //<editor-fold desc="#private (method)">

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
        $vacancyLocation = $this->_vacancyLocationServiceInterface->newInstance();
        $vacancyLocation->name = $name;

        $response = $searchMethod($vacancyLocation);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $parentId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $parentId = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($parentId);
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
     * @param int|null $parentId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $parentId = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId);
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
     * @param int|null $parentId
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $parentId = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $parentId);
        $rowJsonData = $dtoObjectToJsonMethod($response->getDtocCollection(), $export);

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
     * @param int|null $parentId
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $parentId = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $parentId);
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
    
    /**
     * @param VacancyLocationInterface $entity
     * @return Collection
     */
    private function getVacancyLocationParentObject(VacancyLocationInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'title' => $entity->title,
            'vacancy_location_parent' => Common::isDataExist($entity->vacancyLocationParent) ? $this->getVacancyLocationParentObject($entity->vacancyLocationParent) : null,
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}