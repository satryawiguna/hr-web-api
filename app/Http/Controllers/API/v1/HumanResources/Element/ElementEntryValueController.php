<?php

namespace App\Http\Controllers\Api\v1\HumanResources\Element;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Element\ElementEntry\Contracts\ElementEntryInterface;
use App\Domains\HumanResources\Element\ElementEntryValue\Contracts\ElementEntryValueServiceInterface;
use App\Domains\HumanResources\Element\ElementValue\Contracts\ElementValueInterface;
use App\Exports\HumanResources\Element\ElementEntryValueExport;
use App\Helpers\NumericRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ElementEntryValueController extends Controller
{
    use BaseController;

    //<editor-fold desc="#field">

    private $_elementEntryValueServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    public function __construct(ElementEntryValueServiceInterface $elementEntryValueServiceInterface)
    {
        $this->_elementEntryValueServiceInterface = $elementEntryValueServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * @OA\Get(
     *     path="/element-entry-value/list",
     *     operationId="getElementEntryValueList",
     *     summary="Get list of element entry value",
     *     tags={"Element Entry Value"},
     *     description="Get list of element entry value",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\Parameter(
     *          name="element_entry_id",
     *          in="query",
     *          description="Element entry id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="element_value_id",
     *          in="query",
     *          description="Element value id parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *              example=1
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="date",
     *          in="query",
     *          description="Date parameter",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *              example="2020-01-01 00:00:00"
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
    public function getElementEntryValueList(Request $request)
    {
        $elementEntryId = $request->get('element_entry_id');
        $elementValueId = $request->get('element_value_id');
        $date = new DateTime($request->get('date'));
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getListJson($elementEntryId, $elementValueId, $date, $rangeValue,
            [$this->_elementEntryValueServiceInterface, 'elementEntryValueList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element_entry' => $this->getElementEntryObject($entity->element_entry),
                        'element_value' => $this->getElementValueObject($entity->element_value),
                        'effective_start_date' => $entity->effective_start_date,
                        'effective_end_date' => $entity->effective_end_date,
                        'value' => $entity->value,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/element-entry-value/list-search",
     *     operationId="postElementEntryValueListSearch",
     *     summary="Get list of element entry value with query search",
     *     tags={"Element Entry Value"},
     *     description="Get list of element entry value with query search",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="element_entry_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_entry_id"),
     *                  @OA\Property(property="element_value_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_value_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
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
    public function postElementEntryValueListSearch(Request $request)
    {
        $elementEntryId = $request->input('element_entry_id');
        $elementValueId = $request->input('element_value_id');
        $date = new DateTime($request->get('date'));
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getListSearchJson($request, $elementEntryId, $elementValueId, $date, $rangeValue,
            [$this->_elementEntryValueServiceInterface, 'elementEntryValueListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element_entry' => $this->getElementEntryObject($entity->element_entry),
                        'element_value' => $this->getElementValueObject($entity->element_value),
                        'effective_start_date' => $entity->effective_start_date,
                        'effective_end_date' => $entity->effective_end_date,
                        'value' => $entity->value,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Post(
     *     path="/element-entry-value/page-search",
     *     operationId="postElementEntryValuePageSearch",
     *     summary="Get list of element entry value with query and page parameter search",
     *     tags={"Element Entry Value"},
     *     description="Get list of element entry value with query and page parameter search",
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
     *                          @OA\Property(property="element_entry_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_entry_id"),
     *                          @OA\Property(property="element_value_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_value_id"),
     *                          @OA\Property(
     *                              property="date",
     *                              description="Date property",
     *                              type="string",
     *                              format="date-time",
     *                              example="2020-01-01 00:00:00"
     *                          ),
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
    public function postElementEntryValuePageSearch(Request $request)
    {
        $elementEntryId = $request->input('element_entry_id');
        $elementValueId = $request->input('element_value_id');
        $date = new DateTime($request->input('date'));
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getPagedSearchJson($request, $elementEntryId, $elementValueId, $date, $rangeValue,
            [$this->_elementEntryValueServiceInterface, 'elementEntryValuePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element_entry' => $this->getElementEntryObject($entity->element_entry),
                        'element_value' => $this->getElementValueObject($entity->element_value),
                        'effective_start_date' => $entity->effective_start_date,
                        'effective_end_date' => $entity->effective_end_date,
                        'value' => $entity->value,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    /**
     * @OA\Get(
     *     path="/element-entry-value/detail/{id}",
     *     operationId="getElementEntryValueDetail",
     *     summary="Get detail element by id",
     *     tags={"Element Entry Value"},
     *     description="Return element",
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
    public function getElementEntryValueDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_elementEntryValueServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'element_entry' => $this->getElementEntryObject($entity->element_entry),
                        'element_value' => $this->getElementValueObject($entity->element_value),
                        'effective_start_date' => $entity->effective_start_date,
                        'effective_end_date' => $entity->effective_end_date,
                        'value' => $entity->value,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    /**
     * @OA\Post(
     *     path="/element-entry-value/create",
     *     operationId="postElementEntryValueCreate",
     *     summary="Create element",
     *     tags={"Element Entry Value"},
     *     description="Return id of element entry value created",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/CreateElementEntryValueEloquent")
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
    public function postElementEntryValueCreate(Request $request)
    {
        $element = $this->_elementEntryValueServiceInterface->newInstance();

        $element->element_entry_id = $request->input('element_entry_id');
        $element->element_value_id = $request->input('element_value_id');
        $element->effective_start_date = ($request->input('effective_start_date')) ? new DateTime($request->input('effective_start_date')) : null;
        $element->effective_end_date = ($request->input('effective_end_date')) ? new DateTime($request->input('effective_end_date')) : null;
        $element->value = $request->input('value');

        $this->setRequestAuthor($element);

        $response = $this->_elementEntryValueServiceInterface->create($element);
        $elementCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $elementCreated);
    }

    /**
     * @OA\Put(
     *     path="/element-entry-value/update",
     *     operationId="putElementEntryValueUpdate",
     *     summary="Update element",
     *     tags={"Element Entry Value"},
     *     description="Return object of element entry value updated",
     *     security={
     *          {
     *              "apiKey": {"*"}
     *          }
     *     },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/UpdateElementEntryEloquent")
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
    public function putElementEntryValueUpdate(Request $request)
    {
        $element = $this->_elementEntryValueServiceInterface->find($request->input('id'));

        $result = $element->getObject();

        $result->element_entry_id = $request->input('element_entry_id');
        $result->element_value_id = $request->input('element_value_id');
        $result->effective_start_date = ($request->input('effective_start_date')) ? new DateTime($request->input('effective_start_date')) : null;
        $result->effective_end_date = ($request->input('effective_end_date')) ? new DateTime($request->input('effective_end_date')) : null;
        $result->value = $request->input('value');

        $this->setRequestAuthor($result);

        $response = $this->_elementEntryValueServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/element-entry-value/delete/{id}",
     *     operationId="deleteElementEntryValue",
     *     summary="Delete element",
     *     tags={"Element Entry Value"},
     *     description="Delete element",
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
    public function postElementEntryValueDelete(int $id)
    {
        $element = $this->_elementEntryValueServiceInterface->find($id);

        $result = $element->getObject();

        $response = $this->_elementEntryValueServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Delete(
     *     path="/element-entry-value/deletes",
     *     operationId="deleteBulkElementEntryValue",
     *     summary="Delete bulk element entry value",
     *     tags={"Element Entry Value"},
     *     description="Delete bulk element entry value",
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
    public function deleteBulkElementEntryValue(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_elementEntryValueServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    /**
     * @OA\Post(
     *     path="/element-entry-value/list-search/export",
     *     operationId="postElementEntryValueListSearchExport",
     *     summary="Export list of element entry value",
     *     tags={"Element Entry Value"},
     *     description="Export list of element entry value",
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
     *                  @OA\Property(property="element_entry_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_entry_id"),
     *                  @OA\Property(property="element_value_id", ref="#/components/schemas/ElementEntryValueEloquent/properties/element_value_id"),
     *                  @OA\Property(
     *                      property="date",
     *                      description="Date property",
     *                      type="string",
     *                      format="date-time",
     *                      example="2020-01-01 00:00:00"
     *                  ),
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
    public function postElementEntryValueListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $elementEntryId = $request->input('element_entry_id');
        $elementValueId = $request->input('element_value_id');
        $date = new DateTime($request->get('date'));
        $rangeValue = new NumericRange($request->get('start_value'), $request->get('end_value'));

        return $this->getListSearchExportJson($request, $export, $elementEntryId, $elementValueId, $date, $rangeValue,
            [$this->_elementEntryValueServiceInterface, 'elementEntryValueListSearch'],
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

        if (Excel::store(new ElementEntryValueExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.element.element-entry-value', ['elementEntryValues' => $entities])
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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($elementEntryId, $elementValueId, $date, $rangeValue);
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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $elementEntryId, $elementValueId, $date, $rangeValue);
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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $elementEntryId, $elementValueId, $date, $rangeValue);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoCollection(), $export);

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
     * @param int|null $elementEntryId
     * @param int|null $elementValueId
     * @param DateTime|null $date
     * @param object|null $rangeValue
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $elementEntryId = null, int $elementValueId = null, DateTime $date = null, object $rangeValue = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $elementEntryId, $elementValueId, $date, $rangeValue);
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
     * @param ElementEntryInterface $entity
     * @return Collection
     */
    private function getElementEntryObject(ElementEntryInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'effective_start_date' => $entity->effective_start_date,
            'effective_end_date' => $entity->effective_end_date
        ]);

        return $rowJsonData;
    }

    /**
     * @param ElementValueInterface $entity
     * @return Collection
     */
    private function getElementValueObject(ElementValueInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'code' => $entity->code,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    //</editor-fold>
}
