<?php

namespace App\Domains\HumanResources\Personal\Employee\Child;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\Child\Contracts\EloquentChildRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\Child\Contracts\ChildInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class ChildRepository.
 */
class ChildRepository extends RepositoryAbstract implements ChildRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ChildRepository constructor.
     *
     * @param EloquentChildRepositoryInterface $eloquent
     */
    public function __construct(EloquentChildRepositoryInterface $eloquent)
    {
        parent::__construct($eloquent);
    }

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Setup payload.
     *
     * @return array
     */
    public function setupPayload(ChildInterface $Child)
    {
        return [
            'employee_id' => $Child->getEmployeeId(),
            'gender_id' => $Child->getGenderId(),
            'full_name' => $Child->getFullName(),
            'nick_name' => $Child->getNickName(),
            'order' => $Child->getOrder(),
            'birth_place' => $Child->getBirthPlace(),
            'birth_date' => (!is_null($Child->getBirthDate())) ? $Child->getBirthDate()->format(Config::get('datetime.format.default')) : null,
            'has_bpjs_kesehatan' => $Child->getHasBpjsKesehatan(),
            'bpjs_kesehatan_number' => $Child->getBpjsKesehatanNumber(),
            'bpjs_kesehatan_date' => (!is_null($Child->getBpjsKesehatanDate())) ? $Child->getBpjsKesehatanDate()->format(Config::get('datetime.format.default')) : null,
            'bpjs_kesehatan_class' => $Child->getBpjsKesehatanClass(),
            'created_by' => $Child->getCreatedBy(),
            'modified_by' => $Child->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ChildInterface $Child)
    {
        $data = $this->setupPayload($Child);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $Childs
     * @return mixed
     */
    public function insert(Collection $Childs)
    {
        return $this->eloquent()->insert($Childs->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(ChildInterface $Child)
    {
        $data = $this->setupPayload($Child);
       
        return $this->eloquent()->update($data, $Child->getKey());
    }

    /**
     * @param ChildInterface $Child
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(ChildInterface $Child, array $params)
    {
        $data = $this->setupPayload($Child);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ChildInterface $Child)
    {
        return $this->eloquent()->delete($Child->getKey());
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteBulk(array $ids)
    {
        return $this->eloquent()->delete($ids);
    }

    /**
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @return mixed
     */
    public function childList(int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($genderId)) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!is_null($rangeBPJSKesehatanDate->start) &&
            !is_null($rangeBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSKesehatanDate($rangeBPJSKesehatanDate->start, $rangeBPJSKesehatanDate->end);
        }

        if (!is_null($bpjsKesehatanClass)) {
            $this->eloquent->findWhereByBPJSKesehatanClass($bpjsKesehatanClass);
        }

        return $this->eloquent->with(['employee' => function($query) {
            return $query->with(['company']);
        }])
            ->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param bool $count
     * @return mixed
     */
    public function childListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($genderId)) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!is_null($rangeBPJSKesehatanDate->start) &&
            !is_null($rangeBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSKesehatanDate($rangeBPJSKesehatanDate->start, $rangeBPJSKesehatanDate->end);
        }

        if (!is_null($bpjsKesehatanClass)) {
            $this->eloquent->findWhereByBPJSKesehatanClass($bpjsKesehatanClass);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }, 'gender'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $genderId
     * @param object|null $rangeBirthDate
     * @param object|null $rangeBPJSKesehatanDate
     * @param string|null $bpjsKesehatanClass
     * @param bool $count
     * @return mixed
     */
    public function childPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $genderId = null, object $rangeBirthDate = null, object $rangeBPJSKesehatanDate = null, string $bpjsKesehatanClass = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($genderId)) {
            $this->eloquent->findWhereByGenderId($genderId);
        }

        if (!is_null($rangeBirthDate->start) &&
            !is_null($rangeBirthDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBirthDate($rangeBirthDate->start, $rangeBirthDate->end);
        }

        if (!is_null($rangeBPJSKesehatanDate->start) &&
            !is_null($rangeBPJSKesehatanDate->end)) {
            $this->eloquent->findWhereBetweenByRangeBPJSKesehatanDate($rangeBPJSKesehatanDate->start, $rangeBPJSKesehatanDate->end);
        }

        if (!is_null($bpjsKesehatanClass)) {
            $this->eloquent->findWhereByBPJSKesehatanClass($bpjsKesehatanClass);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'gender'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'gender'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
