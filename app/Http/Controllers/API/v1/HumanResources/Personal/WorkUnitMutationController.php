<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\MasterData\WorkUnit\Contracts\WorkUnitInterface;
use App\Domains\HumanResources\Personal\WorkUnitMutation\Contracts\WorkUnitMutationServiceInterface;
use App\Exports\HumanResources\Personal\WorkUnitMutationExport;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class WorkUnitMutationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_workUnitMutationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * WorkUnitMutationController constructor.
     * @param WorkUnitMutationServiceInterface $workUnitMutationServiceInterface
     */
    public function __construct(WorkUnitMutationServiceInterface $workUnitMutationServiceInterface)
    {
        $this->_workUnitMutationServiceInterface = $workUnitMutationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    public function getWorkUnitMutationList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $workUnitId = $request->get('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->get('start_mutation_date'), $request->get('end_mutation_date'));

        return $this->getListJson($companyId, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->work_unit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postWorkUnitMutationListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $workUnitId = $request->input('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchJson($request, $companyId, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->work_unit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postWorkUnitMutationPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $workUnitId = $request->input('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->work_unit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function getWorkUnitMutationDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_workUnitMutationServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'work_unit' => $this->getWorkUnitObject($entity->work_unit),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    public function postWorkUnitMutationCreate(Request $request)
    {
        $workUnitMutation = $this->_workUnitMutationServiceInterface->newInstance();

        $workUnitMutation->employee_id = $request->input('employee_id');
        $workUnitMutation->work_unit_id = $request->input('work_unit_id');
        $workUnitMutation->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;
        $workUnitMutation->note = $request->input('note');

        $this->setRequestAuthor($workUnitMutation);

        $response = $this->_workUnitMutationServiceInterface->create($workUnitMutation);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function putWorkUnitMutationUpdate(Request $request)
    {
        $workUnitMutation = $this->_workUnitMutationServiceInterface->find($request->input('id'));

        $result = $workUnitMutation->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->work_unit_id = $request->input('work_unit_id');
        $result->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;
        $result->note = $request->input('note');

        $this->setRequestAuthor($result);

        $response = $this->_workUnitMutationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteWorkUnitMutation(int $id)
    {
        $workUnitMutation = $this->_workUnitMutationServiceInterface->find($id);

        $result = $workUnitMutation->getObject();

        $response = $this->_workUnitMutationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteBulkWorkUnitMutation(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_workUnitMutationServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function postChildListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $compayId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $workUnitId = $request->input('work_unit_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchExportJson($request, $export, $compayId, $employeeId, $workUnitId, $rangeMutationDate,
            [$this->_workUnitMutationServiceInterface, 'workUnitMutationListSearch'],
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

        if (Excel::store(new WorkUnitMutationExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.work-unit-mutation', ['workUnitMutations' => $entities])
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $workUnitId, $rangeMutationDate);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $workUnitId, $rangeMutationDate);
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
     * @param int|null $compayId
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $compayId = null, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $compayId, $employeeId, $workUnitId, $rangeMutationDate);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $workUnitId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $workUnitId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $workUnitId, $rangeMutationDate);
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
     * @param EmployeeInterface $entity
     * @return Collection
     */
    private function getEmployeeObject(EmployeeInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param WorkUnitInterface $entity
     * @return Collection
     */
    private function getWorkUnitObject(WorkUnitInterface $entity)
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
