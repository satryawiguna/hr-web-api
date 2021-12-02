<?php

namespace App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\EloquentOtherEquipmentRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\OtherEquipment\Contracts\OtherEquipmentInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use Illuminate\Support\Collection;

/**
 * Class OtherEquipmentRepository.
 */
class OtherEquipmentRepository extends RepositoryAbstract implements OtherEquipmentRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OtherEquipmentRepository constructor.
     *
     * @param EloquentOtherEquipmentRepositoryInterface $eloquent
     */
    public function __construct(EloquentOtherEquipmentRepositoryInterface $eloquent)
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
    public function setupPayload(OtherEquipmentInterface $OtherEquipment)
    {
        return [
            'employee_id' => $OtherEquipment->getEmployeeId(),
            'name' => $OtherEquipment->getName(),
            'description' => $OtherEquipment->getDescription(),
            'created_by' => $OtherEquipment->getCreatedBy(),
            'modified_by' => $OtherEquipment->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(OtherEquipmentInterface $OtherEquipment)
    {
        $data = $this->setupPayload($OtherEquipment);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $OtherEquipments
     * @return mixed
     */
    public function insert(Collection $OtherEquipments)
    {
        return $this->eloquent()->insert($OtherEquipments->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(OtherEquipmentInterface $OtherEquipment)
    {
        $data = $this->setupPayload($OtherEquipment);
       
        return $this->eloquent()->update($data, $OtherEquipment->getKey());
    }

    /**
     * @param OtherEquipmentInterface $OtherEquipment
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(OtherEquipmentInterface $OtherEquipment, array $params)
    {
        $data = $this->setupPayload($OtherEquipment);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OtherEquipmentInterface $OtherEquipment)
    {
        return $this->eloquent()->delete($OtherEquipment->getKey());
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
     * @return mixed
     */
    public function otherEquipmentList(int $companyId = null, int $employeeId = null)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        return $this->eloquent->with(['employee' => function($query) {
            return $query->with(['company']);
        }])->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param bool $count
     * @return mixed
     */
    public function otherEquipmentListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param bool $count
     * @return mixed
     */
    public function otherEquipmentPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, bool $count = false)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
