<?php

namespace App\Http\Controllers\API\v1\HumanResources\Personal;

use App\Core\Services\Response\BooleanResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Commons\Company\Contracts\CompanyInterface;
use App\Domains\HumanResources\Personal\Employee\Contracts\EmployeeInterface;
use App\Domains\HumanResources\Personal\ProjectMutation\Contracts\ProjectMutationServiceInterface;
use App\Domains\HumanResources\Project\Contracts\ProjectInterface;
use App\Exports\HumanResources\Personal\ProjectMuationExport;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ProjectMutationController extends Controller
{
    use BaseController;


    //<editor-fold desc="#field">

    private $_projectMutationServiceInterface;

    //</editor-fold>


    //<editor-fold desc="#constructor">

    /**
     * ProjectMutationController constructor.
     * @param ProjectMutationServiceInterface $projectMutationServiceInterface
     */
    public function __construct(ProjectMutationServiceInterface $projectMutationServiceInterface)
    {
        $this->_projectMutationServiceInterface = $projectMutationServiceInterface;
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    public function getProjectMutationList(Request $request)
    {
        $companyId = $request->get('company_id');
        $employeeId = $request->get('employee_id');
        $projectId = $request->get('project_id');
        $rangeMutationDate = new DateTimeRange($request->get('start_mutation_date'), $request->get('end_mutation_date'));

        return $this->getListJson($companyId, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationList'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postProjectMutationListSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $projectId = $request->input('project_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchJson($request, $companyId, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationListSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function postProjectMutationPageSearch(Request $request)
    {
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $projectId = $request->input('project_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getPagedSearchJson($request, $companyId, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationPageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData;
            });
    }

    public function getProjectMutationDetail(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_projectMutationServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'employee' => $this->getEmployeeObject($entity->employee),
                        'project' => $this->getProjectObject($entity->project),
                        'mutation_date' => $entity->mutation_date,
                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by
                    ]);
                }

                return $rowJsonData->first();
            });
    }

    public function postProjectMutationCreate(Request $request)
    {
        $projectMutation = $this->_projectMutationServiceInterface->newInstance();

        $projectMutation->employee_id = $request->input('employee_id');
        $projectMutation->project_id = $request->input('project_id');
        $projectMutation->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;

        $this->setRequestAuthor($projectMutation);

        $response = $this->_projectMutationServiceInterface->create($projectMutation);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function putProjectMutationUpdate(Request $request)
    {
        $projectMutation = $this->_projectMutationServiceInterface->find($request->input('id'));

        $result = $projectMutation->getObject();

        $result->employee_id = $request->input('employee_id');
        $result->project_id = $request->input('project_id');
        $result->mutation_date = ($request->input('mutation_date')) ? new DateTime($request->input('mutation_date')) : null;

        $this->setRequestAuthor($result);

        $response = $this->_projectMutationServiceInterface->update($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteProjectMutation(int $id)
    {
        $projectMutation = $this->_projectMutationServiceInterface->find($id);

        $result = $projectMutation->getObject();

        $response = $this->_projectMutationServiceInterface->delete($result);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteBulkProjectMutation(Request $request)
    {
        $ids = $request->input('ids');

        $response = $this->_projectMutationServiceInterface->deleteBulk($ids);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function postProjectMutationListSearchExport(Request $request)
    {
        $export = $request->input('export');
        $companyId = $request->input('company_id');
        $employeeId = $request->input('employee_id');
        $projectId = $request->input('project_id');
        $rangeMutationDate = new DateTimeRange($request->input('start_mutation_date'), $request->input('end_mutation_date'));

        return $this->getListSearchExportJson($request, $export, $companyId, $employeeId, $projectId, $rangeMutationDate,
            [$this->_projectMutationServiceInterface, 'projectMutationListSearch'],
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

        $path = 'pubic/';
        $file = uniqid() . $ext;

        if (Excel::store(new ProjectMuationExport($entities), $path . $file)) {
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

        if (PDF::loadView('exports.human-resources.personal.project-mutation', ['projectMutations' => $entities])
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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListJson(int $companyId = null, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                 callable $searchMethod,
                                 callable $dtoCollectionToRowJsonMethod)
    {
        $response = $searchMethod($companyId, $employeeId, $projectId, $rangeMutationDate);
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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                       callable $searchMethod,
                                       callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $projectId, $rangeMutationDate);
        $rowJsonData = $dtoCollectionToRowJsonMethod($response->getDtoColection());

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
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoObjectToJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getListSearchExportJson(Request $request, string $export = null, int $companyId = null, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                                   callable $searchMethod,
                                                   callable $dtoObjectToJsonMethod)
    {
        $parameter = $this->generateListSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $projectId, $rangeMutationDate);
        $itemJsonData = $dtoObjectToJsonMethod($response->_dtoCollection, $export);

        $jsonData = response()->json($itemJsonData);

        return $jsonData;
    }

    /**
     * @param Request $request
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $projectId
     * @param object|null $rangeMutationDate
     * @param callable $searchMethod
     * @param callable $dtoCollectionToRowJsonMethod
     * @return \Illuminate\Http\JsonResponse
     */
    private function getPagedSearchJson(Request $request, int $companyId = null, int $employeeId = null, int $projectId = null, object $rangeMutationDate = null,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $companyId, $employeeId, $projectId, $rangeMutationDate);
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
     * @param ProjectInterface $entity
     * @return Collection
     */
    private function getProjectObject(ProjectInterface $entity)
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
