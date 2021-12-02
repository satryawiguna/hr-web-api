<?php

namespace App\Http\Controllers\API\v1\Demo;

use App\Domains\Demo\Employee\Contracts\EmployeeServiceInterface;
use App\Domains\Demo\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Domains\Demo\Employee\Contracts\Request\EditEmployeeRequest;
use App\Helpers\DateTimeRange;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DemoController extends Controller
{
    use BaseController;

    private $_employeeServiceInterface;

    public function __construct(EmployeeServiceInterface $employeeServiceInterface)
    {
        $this->_employeeServiceInterface = $employeeServiceInterface;
    }


    public function postEmployeePageSearch(Request $request)
    {
        $rangeBirthDate = new DateTimeRange($request->input('start_birth_date'), $request->input('end_birth_date'));

        return $this->getPagedSearchJson($request,
            [$this->_employeeServiceInterface, 'employeePageSearch'],
            function (Collection $entities) {
                $rowJsonData = new Collection();

                foreach ($entities as $entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,

                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                    ]);
                }

                return $rowJsonData;
            },  $rangeBirthDate);
    }

    public function postEmployee(Request $request)
    {
        $createEmployeeRequest = new CreateEmployeeRequest();

        $createEmployeeRequest->nip = $request->input('nip');
        $createEmployeeRequest->full_name = $request->input('full_name');
        $createEmployeeRequest->nick_name = $request->input('nick_name');
        $createEmployeeRequest->birth_date = ($request->input('birth_date')) ? new DateTime($request->input('birth_date')) : null;
        $createEmployeeRequest->address = $request->input('address');
        $createEmployeeRequest->phone = $request->input('phone');
        $createEmployeeRequest->mobile = $request->input('mobile');
        $createEmployeeRequest->email = $request->input('email');

        $this->setRequestAuthor($createEmployeeRequest);

        $response = $this->_employeeServiceInterface->create($createEmployeeRequest);
        $employeeCreated = $response->getObject();

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response, $employeeCreated);
    }

    public function putEmployee(int $id, Request $request)
    {
        $editEmployeeRequest = new EditEmployeeRequest();

        $editEmployeeRequest->id = $id;

        $editEmployeeRequest->nip = $request->input('nip');
        $editEmployeeRequest->full_name = $request->input('full_name');
        $editEmployeeRequest->nick_name = $request->input('nick_name');
        $editEmployeeRequest->birth_date = ($request->input('birth_date')) ? new DateTime($request->input('birth_date')) : null;
        $editEmployeeRequest->address = $request->input('address');
        $editEmployeeRequest->phone = $request->input('phone');
        $editEmployeeRequest->mobile = $request->input('mobile');
        $editEmployeeRequest->email = $request->input('email');

        $this->setRequestAuthor($editEmployeeRequest);

        $response = $this->_employeeServiceInterface->update($editEmployeeRequest);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function deleteEmployee(int $id)
    {
        $response = $this->_employeeServiceInterface->delete($id);

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    public function getEmployee(int $id)
    {
        return $this->getDetailObjectJson($id,
            [$this->_employeeServiceInterface, 'find'],
            function ($entity) {
                $rowJsonData = new Collection();

                if ($entity) {
                    $rowJsonData->push([
                        'id' => $entity->id,
                        'nip' => $entity->nip,
                        'full_name' => $entity->full_name,
                        'nick_name' => $entity->nick_name,
                        'birth_date' => $entity->birth_date,
                        'address' => $entity->address,
                        'phone' => $entity->phone,
                        'email' => $entity->email,
                        'mobile' => $entity->mobile,

                        'created_by' => $entity->created_by,
                        'modified_by' => $entity->modified_by,
                    ]);
                }

                return $rowJsonData->first();
            });
    }


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

    private function getPagedSearchJson(Request $request,
                                        callable $searchMethod,
                                        callable $dtoCollectionToRowJsonMethod,
                                        object $rangeBirthDate = null)
    {
        $parameter = $this->generatePageSearchParameter($request);
        $response = $searchMethod($parameter, $rangeBirthDate);
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