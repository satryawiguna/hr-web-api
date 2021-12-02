<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\MasterData\Grade\Contracts\GradeInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\MasterData\Position\Contracts\PositionInterface;
use App\Domains\HumanResources\Personal\PositionMutation\Contracts\PositionMutationServiceInterface;
use App\Exports\HumanResources\Personal\PositionMutationExport;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class PositionMutationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_positionMutationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * PositionMutationController constructor.
     * @param PositionMutationServiceInterface $positionMutationServiceInterface
     */
    public function __construct(PositionMutationServiceInterface $positionMutationServiceInterface)
    {
        $this->_positionMutationServiceInterface = $positionMutationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    
    public function getPositionMutationList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $positionId = $request->get('position_id');
        $gradeId = $request->get('grade_id');
        $rangeMutationDate = new DateTimeRange($request->get('start_mutation_date'), $request->get('end_mutation_date'));

        return $this->getListJson($companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postPositionMutationListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $positionId = $request->input('position_id');
        $gradeId = $request->input('grade_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchJson($request, $companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postPositionMutationPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $positionId = $request->input('position_id');
        $gradeId = $request->input('grade_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function getPositionMutationDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_positionMutationServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'position' => $this->getPositionObject($entity->position),
                        'grade' => $this->getGradeObject($entity->grade),
                        'mutation_date' => $entity->mutation_date,
                        'note' => $entity->note,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    public function postPositionMutationCreate(Request $request)
    {
        $positionMutation = $this->_positionMutationServiceInterface->newInstance();

        $positionMutation->employee_id = $request->input('employee_id');
        $positionMutation->position_id = $request->input('position_id');
        $positionMutation->grade_id = $request->input('grade_id');
        $positionMutation->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;
        $positionMutation->note = $request->input('note');

        $this->setRequestAuthor($positionMutation);

        $response = $this->_positionMutationServiceInterface->create($positionMutation);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function putPositionMutationUpdate(Request $request)
    {
        $positionMutation = $this->_positionMutationServiceInterface->find($request->input('id'));

        $result = $positionMutation->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->position_id = $request->input('position_id');
        $result->grade_id = $request->input('grade_id');
        $result->mutation_date = new DateTime($request->input('mutation_date'));
        $result->note = $request->input('note');

        $this->setRequestAuthor($result);

        $response = $this->_positionMutationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    
    public function deletePositionMutation(int $id)
    {
        $positionMutation = $this->_positionMutationServiceInterface->find($id);

        $result = $positionMutation->getObject();

        $response = $this->_positionMutationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    
    public function deleteBulkPositionMutation(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_positionMutationServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function postPositionMutationListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $positionId = $request->input('position_id');
        $gradeId = $request->input('grade_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate,
            [$this->_positionMutationServiceInterface, 'positionMutationListSearch'],
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

        if (Excel::store(new PositionMutationExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.position-mutation', ['positionMutations' => $entities])
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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate);
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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate);
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
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate);
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
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $positionId
     * @param int|null $gradeId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $positionId = null, int $gradeId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $positionId, $gradeId, $rangeMutationDate);
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
            'company' => $this->getCompanyObject($entity->company),
            'full_name' => $entity->full_name,
            'nick_name' => $entity->nick_name
        ]);

        return $rowJsonData;
    }

    /**
     * @param CompanyInterface $entity
     * @return Collection
     */
    private function getCompanyObject(CompanyInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param PositionInterface $entity
     * @return Collection
     */
    private function getPositionObject(PositionInterface $entity)
    {
        $rowJsonData = new Collection();

        $rowJsonData->push([
            'id' => $entity->id,
            'name' => $entity->name
        ]);

        return $rowJsonData;
    }

    /**
     * @param GradeInterface $entity
     * @return Collection
     */
    private function getGradeObject(GradeInterface $entity)
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
