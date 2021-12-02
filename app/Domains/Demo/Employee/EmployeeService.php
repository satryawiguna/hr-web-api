<?php


namespace App\Domains\Demo\Employee;


use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericPageSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Domains\Demo\Employee\Contracts\EmployeeRepositoryInterface;
use App\Domains\Demo\Employee\Contracts\EmployeeServiceInterface;
use App\Domains\Demo\Employee\Contracts\Request\CreateEmployeeRequest;
use App\Domains\Demo\Employee\Contracts\Request\EditEmployeeRequest;
use App\Domains\ServiceAbstract;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Validator;

class EmployeeService extends ServiceAbstract implements EmployeeServiceInterface
{
    protected $repository;

    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(CreateEmployeeRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'nip' => 'required',
            'full_name' => 'required',
            'address' => 'required',
            'email' => 'required|email'
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        try {
            $employee = $this->repository->newInstance([
                'nip' => $request->nip,
                'full_name' => $request->full_name,
                'nick_name' => $request->nick_name,
                'birth_date' => $request->birth_date,
                'address' => $request->address,
                'phone' => $request->phone,
                'mobile' => $request->mobile,
                'email' => $request->email
            ]);

            $this->setAuditableInformationFromRequest($employee, $request);

            $result = $this->repository->create($employee);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee was created', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    public function update(EditEmployeeRequest $request): ObjectResponse
    {
        $response = new ObjectResponse();

        $rules = [
            'nip' => 'required',
            'full_name' => 'required',
            'address' => 'required',
            'email' => 'required|email'
        ];

        $validator = Validator::make((array) $request, $rules);

        if ($validator->fails()) {
            $response->addErrorMessageResponse($response->getMessageCollection(), $validator->errors(), 400);

            return $response;
        }

        $employee = $this->repository->find($request->id);

        $employee->fill([
            "nip" => $request->nip,
            "full_name" => $request->full_name,
            "nick_name" => $request->nick_name,
            "birth_date" => $request->birth_date,
            "address"   => $request->address,
            "phone" => $request->phone,
            "mobile" => $request->mobile,
            "email" => $request->email
        ]);

        $this->setAuditableInformationFromRequest($employee);

        try {
            $result = $this->repository->update($employee);

            $response->setResult($result);
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee was updated', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    public function delete(int $id): BasicResponse
    {
        $response = new BasicResponse();

        try {
            $employee = $this->find($id);

            $this->repository->delete($employee->getResult());

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Employee was deleted', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }

    public function employeePageSearch(PageSearchRequest $pageSearchRequest, object $rangeBirthDate = null): GenericPageSearchResponse
    {
        $response = new GenericPageSearchResponse();

        $parameter = new PagedSearchParameter();

        try {
            if ($pageSearchRequest->draw) {
                $parameter->draw = $pageSearchRequest->draw;
                $parameter->columns = $pageSearchRequest->columns;
                $parameter->order = $pageSearchRequest->order;
                $parameter->start = $pageSearchRequest->start;
                $parameter->length = $pageSearchRequest->length;
                $parameter->search = $pageSearchRequest->search;
            } else {
                $parameter->pagination = $pageSearchRequest->pagination;
                $parameter->query = $pageSearchRequest->query;
                $parameter->sort = $pageSearchRequest->sort;
            }

            $results = $this->repository->employeePageSearch($parameter, $rangeBirthDate);
            $totalCount = $this->repository->employeePageSearch($parameter, $rangeBirthDate, true);
            if ($pageSearchRequest->draw) {
                $totalPage = ceil($totalCount / $parameter->length);
            } else {
                $totalPage = ceil($totalCount / $parameter->pagination['perpage']);
            }

            $response->setDtoList($results);
            $response->setTotalCount($totalCount);
            $response->setTotalPage($totalPage);

            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Ok', 200);
        } catch (Exception $ex) {
            if (method_exists($ex,'getResponse')) {
                $exception = new ErrorException((string) $ex->getResponse()->getBody());
                $response->addErrorMessageResponse($response->getMessageCollection(), json_decode($exception->getMessage(), true)['message'], $ex->getCode());
            }

            $response->addErrorMessageResponse($response->getMessageCollection(), (string) $ex->getMessage(), 500);
        }

        return $response;
    }
}