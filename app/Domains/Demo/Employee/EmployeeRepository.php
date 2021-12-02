<?php


namespace App\Domains\Demo\Employee;


use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Demo\Employee\Contracts\EmployeeInterface;
use App\Domains\Demo\Employee\Contracts\EmployeeRepositoryInterface;
use App\Domains\RepositoryAbstract;
use App\Infrastructures\Demo\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use DateTime;

class EmployeeRepository extends RepositoryAbstract implements EmployeeRepositoryInterface
{
    public function __construct(EloquentEmployeeRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    public function setupPayload(EmployeeInterface $Employee)
    {
        return [
            'nip' => $Employee->getNip(),
            'full_name' => $Employee->getFullName(),
            'nick_name' => $Employee->getNickName(),
            'birth_date' => $Employee->getBirthDate(),
            'address' => $Employee->getAddress(),
            'email' => $Employee->getEmail(),
            'phone' => $Employee->getPhone(),
            'mobile' => $Employee->getMobile(),
            'created_by' => $Employee->getCreatedBy(),
            'modified_by' => $Employee->getModifiedBy(),
        ];
    }

    public function create(EmployeeInterface $Employee, array $relations = null)
    {
        $data = $this->setupPayload($Employee);

        return $this->eloquent()->create($data, $relations);
    }

    public function update(EmployeeInterface $Employee, array $relations = null)
    {
        $data = $this->setupPayload($Employee);

        return $this->eloquent()->update($data, $Employee->getKey(), $relations);
    }

    public function delete(EmployeeInterface $Employee, array $relations = null)
    {
        return $this->eloquent()->delete($Employee->getKey(), false, $relations);
    }

    public function employeePageSearch(PagedSearchParameter $parameter, object $rangeBirthDate = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], $parameter->pagination['page'] - 1);
            }
        } else {
            return $this->eloquent->all()->count();
        }
    }


}