<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\Employee\EmployeeEloquent;
use App\Domains\HumanResources\Personal\Termination\Contracts\TerminationServiceInterface;
use App\Exports\HumanResources\Personal\TerminationExport;
use App\Helpers\DateTimeRange;
use App\Helpers\NumericRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class TerminationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_terminationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * TerminationController constructor.
     * @param TerminationServiceInterface $terminationServiceInterface
     */
    public function __construct(TerminationServiceInterface $terminationServiceInterface)
    {
        $this->_terminationServiceInterface = $terminationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    public function getTerminationList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->get('start_termination_date'), $request->get('end_termination_date'));
        $rangeSeverance = new NumericRange($request->get('start_severance'), $request->get('end_severance'));

        return $this->getListJson($companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postTerminationListSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));
        $rangeSeverance = new NumericRange($request->input('start_severance'), $request->input('end_severance'));

        return $this->getListSearchJson($request, $companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postTerminationPageSearch(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));
        $rangeSeverance = new NumericRange($request->input('start_severance'), $request->input('end_severance'));

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function getTerminationDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_terminationServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'type' => $entity->type,
                        'termination_date' => $entity->termination_date,
                        'note' => $entity->note,
                        'severance' => $entity->severance,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    public function postTerminationCreate(Request $request)
    {
        $termination = $this->_terminationServiceInterface->newInstance();

        $termination->employee_id = $request->input('employee_id');
        $termination->type = $request->input('type');
        $termination->termination_date = ($request->input('termination_date')) ? new DateTime($request->input('termination_date')) : null;
        $termination->note = $request->input('note');
        $termination->severance = $request->input('severance');

        $this->setRequestAuthor($termination);

        $response = $this->_terminationServiceInterface->create($termination);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function putTerminationUpdate(Request $request)
    {
        $termination = $this->_terminationServiceInterface->find($request->input('id'));

        $result = $termination->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->type = $request->input('type');
        $result->termination_date = ($request->input('termination_date')) ? new DateTime($request->input('termination_date')) : null;
        $result->note = $request->input('note');
        $result->severance = $request->input('severance');
        $this->setRequestAuthor($result);

        $response = $this->_terminationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteTermination(int $id)
    {
        $termination = $this->_terminationServiceInterface->find($id);

        $result = $termination->_dto;

        $response = $this->_terminationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteBulkTermination(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_terminationServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function postTerminationListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $type = $request->get('type');
        $rangeTerminationDate = new DateTimeRange($request->input('start_termination_date'), $request->input('end_termination_date'));
        $rangeSeverance = new NumericRange($request->input('start_severance'), $request->input('end_severance'));

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance,
            [$this->_terminationServiceInterface, 'terminationListSearch'],
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

        if (Excel::store(new TerminationExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.termination', ['terminations' => $entities])
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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param string|null $type
     * @param object|null $rangeTerminationDate
     * @param object|null $rangeSeverance
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, string $type = null, object $rangeTerminationDate = null, object $rangeSeverance = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $type, $rangeTerminationDate, $rangeSeverance);
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
     * @param EmployeeEloquent $entity
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

    //</editor-fold>
}
