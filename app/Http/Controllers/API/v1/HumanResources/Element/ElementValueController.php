<?php

namespace App\Http\Controllers\API\v1\HumanResources\Element;

use App\Core\Services\Response\BooleanResponse;
use App\Domains\HumanResources\Element\Contracts\ElementInterface;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueServiceInterface;
use App\Exports\HumanResources\Element\ElementValueExport;
use App\Helpers\NumericRange;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ElementValueController extends Controller
{
    use BaseController;

    //<editor-fold desc="#field">

    private $_elementValueServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    public function __construct(ElementValueServiceInterface $elementValueServiceInterface)
    {
        $this->_elementValueServiceInterface = $elementValueServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/element-value/list",
     *     operationId="getElementValueList",
     *     summary="Get list of element value",
     *     tags={"Element Value"},
     *     description="Get list of element value",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="element_id",
     *          in="query",
     *          description="Filter element_id of element value by element_id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="start_value",
     *          in="query",
     *          description="Start value parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="0"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="end_value",
     *          in="query",
     *          description="End value parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="float",
     *              example="100"
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
    public function getElementValueList(Request $request)
    {
        $elementId = $request->get('element_id');
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getListJson($elementId, $rangeValue, [$this->_elementValueServiceInterface, 'elementValueList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element' => $this->getElementObject($entity->element),
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'value' => $entity->value,
                        'seq_no' => $entity->seq_no,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/element-value/list-search",
     *     operationId="postElementValueListSearch",
     *     summary="Get list of element value with query search",
     *     tags={"Element Value"},
     *     description="Get list of element value with query search",
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
     *                      description="Query property (Keyword would be filter code, name, slug and seq_no)",
     *                      type="string",
     *                      example="keyword"
     *                  ),
     *                  @OA\Property(property="element_id", ref="#/components/schemas/ElementValueEloquent/properties/element_id"),
     *                  @OA\Property(
     *                      property="start_value",
     *                      description="Start value property",
     *                      type="float",
     *                      example="0"
     *                  ),
     *                  @OA\Property(
     *                      property="end_value",
     *                      description="End value property",
     *                      type="float",
     *                      example="100"
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function postElementValueListSearch(Request $request)
    {
        $elementId = $request->input('element_id');
        $rangeValue = new NumericRange($request->input('start_value'), $request->input('end_value'));

        return $this->getListSearchJson($request, $elementId, $rangeValue,
            [$this->_elementValueServiceInterface, 'elementValueListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element' => $this->getElementObject($entity->element),
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'value' => $entity->value,
                        'seq_no' => $entity->seq_no,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/element-value/page-search",
     *     operationId="postElementValuePageSearch",
     *     summary="Get list of element value with query and page parameter search",
     *     tags={"Element Value"},
     *     description="Get list of element value with query and page parameter search",
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
     *                              description="Query property (Keyword would be filter code, name, slug and seq_no)",
     *                              type="object",
     *                              @OA\Property(
     *                                  property="value",
     *                                  type="string",
     *                                  example="keyword"
     *                              )
     *                          ),
     *                          @OA\Property(property="element_id", ref="#/components/schemas/ElementValueEloquent/properties/element_id"),
     *                          @OA\Property(
     *                              property="start_value",
     *                              description="Start value property",
     *                              type="float",
     *                              example="0"
     *                          ),
     *                          @OA\Property(
     *                              property="end_value",
     *                              description="End value property",
     *                              type="float",
     *                              example="100"
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
    public function postElementValuePageSearch(Request $request)
    {
        $elementId = $request->input('element_id');
        $rangeValue = new NumericRange($request->input('start_value'), $request->input('end_value'));

        return $this->getPagedSearchJson($request, $elementId, $rangeValue,
            [$this->_elementValueServiceInterface, 'elementValuePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element' => $this->getElementObject($entity->element),
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'value' => $entity->value,
                        'seq_no' => $entity->seq_no,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/element-value/detail/{id}",
     *     operationId="getElementValueDetail",
     *     summary="Get detail element value",
     *     tags={"Element Value"},
     *     description="Get detail element value",
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
    public function getElementValueDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_elementValueServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element' => $this->getElementObject($entity->element),
                        'code' => $entity->code,
                        'name' => $entity->name,
                        'slug' => $entity->slug,
                        'value' => $entity->value,
                        'seq_no' => $entity->seq_no,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/element-value/create",
     *     operationId="postElementValueCreate",
     *     summary="Create element value",
     *     tags={"Element Value"},
     *     description="Create element value",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateElementValueEloquent")
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
    public function postElementValueCreate(Request $request)
    {
        $elementValue = $this->_elementValueServiceInterface->newInstance();

        $elementValue->element_id = $request->input('element_id');
        $elementValue->code = $request->input('code');
        $elementValue->name = $request->input('name');
        $elementValue->slug = $request->input('slug');
        $elementValue->value = $request->input('value');
        $elementValue->seq_no = $request->input('seq_no');

        $this->setRequestAuthor($elementValue);

        $response = $this->_elementValueServiceInterface->create($elementValue);
        $elementValueCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $elementValueCreated);
    }

    /**
     * @OA\Put(
     *     path="/element-value/update",
     *     operationId="putElementValueUpdate",
     *     summary="Update element value",
     *     tags={"Element Value"},
     *     description="Update element value",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateElementValueEloquent")
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
    public function putElementValueUpdate(Request $request)
    {
        $elementValue = $this->_elementValueServiceInterface->find($request->input('id'));

        $result = $elementValue->getObject();

        $result->element_id = $request->input('element_id');
        $result->code = $request->input('code');
        $result->name = $request->input('name');
        $result->slug = $request->input('slug');
        $result->value = $request->input('value');
        $result->seq_no = $request->input('seq_no');

        $this->setRequestAuthor($result);

        $response = $this->_elementValueServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/element-value/delete/{id}",
     *     operationId="deleteElementValue",
     *     summary="Delete element value",
     *     tags={"Element Value"},
     *     description="Delete element value",
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
    public function deleteElementValue(int $id)
    {
        $elementValue = $this->_elementValueServiceInterface->find($id);

        $result = $elementValue->getObject();

        $response = $this->_elementValueServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/element-value/deletes",
     *     operationId="deleteBulkElementValue",
     *     summary="Delete bulk element value",
     *     tags={"Element Value"},
     *     description="Delete bulk element value",
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
    public function deleteBulkElementValue(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_elementValueServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Get(
     *     path="/element-value/slug/{name}",
     *     operationId="getElementValueSlug",
     *     summary="Get slug of element value",
     *     tags={"Element Value"},
     *     description="Get slug of element value",
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
     *              type="string",
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
    public function getElementValueSlug(string $name)
    {
        return $this->getSlugObjectJson($name,
            [$this->_elementValueServiceInterface, 'elementValueSlug'],
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
     *     path="/element-value/list-search/export",
     *     operationId="postElementValueListSearchExport",
     *     summary="Export list of element value",
     *     tags={"Element Value"},
     *     description="Export list of element value",
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
     *                  @OA\Property(property="element_id", ref="#/components/schemas/ElementValueEloquent/properties/element_id"),
     *                  @OA\Property(
     *                      property="start_value",
     *                      description="Start value property",
     *                      type="float",
     *                      example="0"
     *                  ),
     *                  @OA\Property(
     *                      property="end_value",
     *                      description="End value property",
     *                      type="float",
     *                      example="100"
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
    public function postElementValueListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $elementId = $request->input('element_id');
        $rangeValue = new NumericRange($request->input('start_value'), $request->input('end_value'));

        return $this->getListSearchExportJson($request, $export, $elementId, $rangeValue,
            [$this->_elementValueServiceInterface, 'elementValueListSearch'],
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

        if (Excel::store(new ElementValueExport($entities), $path . $file)) {
            $response->setResult(true);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Success file generate', 200);
        } else {
            $response->setResult(false);
            $response->addErrorMessageResponse($response->getMessageCollection(),'Invalid file generate', 400);
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

        if (PDF::loadView('exports.human-resources.element.element-value', ['elementValues' => $entities])
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
        $formula = $this->_elementValueServiceInterface->newInstance();
        $formula->name = $name;

        $response = $searchMethod($formula);
        $itemJsonData = $dtoObjectToJsonMethod($response->getObject());

        if ($response->isSuccess()) {
            return response()->json($itemJsonData);
        }

        return $this->getBasicErrorJson($response);
    }

    /**
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $elementId = null, object $rangeValue = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($elementId, $rangeValue);
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
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $elementId = null, object $rangeValue = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $elementId, $rangeValue);
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
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $elementId = null, object $rangeValue = null,
                                             callable $searchMethod,
                                             callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $elementId, $rangeValue);
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
     * @param int|null $elementId
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $elementId = null, object $rangeValue = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $elementId, $rangeValue);
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
     * @param ElementInterface $entity
     * @return Collection
     */
    private function getElementObject(ElementInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
