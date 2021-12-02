<?php

namespace App\Domains\HumanResources\Personal\Employee\FormalEducationHistory;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryRepositoryInterface;
use App\Infrastructures\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\EloquentFormalEducationHistoryRepositoryInterface;
use App\Domains\HumanResources\Personal\Employee\FormalEducationHistory\Contracts\FormalEducationHistoryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Class FormalEducationHistoryRepository.
 */
class FormalEducationHistoryRepository extends RepositoryAbstract implements FormalEducationHistoryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * FormalEducationHistoryRepository constructor.
     *
     * @param EloquentFormalEducationHistoryRepositoryInterface $eloquent
     */
    public function __construct(EloquentFormalEducationHistoryRepositoryInterface $eloquent)
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
    public function setupPayload(FormalEducationHistoryInterface $FormalEducationHistory)
    {
        return [
            'employee_id' => $FormalEducationHistory->getEmployeeId(),
            'degree_id' => $FormalEducationHistory->getDegreeId(),
            'major_id' => $FormalEducationHistory->getMajorId(),
            'name' => $FormalEducationHistory->getName(),
            'start_date' => (!is_null($FormalEducationHistory->getStartDate())) ? $FormalEducationHistory->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($FormalEducationHistory->getEndDate())) ? $FormalEducationHistory->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'created_by' => $FormalEducationHistory->getCreatedBy(),
            'modified_by' => $FormalEducationHistory->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(FormalEducationHistoryInterface $FormalEducationHistory)
    {
        $data = $this->setupPayload($FormalEducationHistory);

        return $this->eloquent()->create($data);
    }

    /**
     * @param Collection $FormalEducationHistories
     * @return mixed
     */
    public function insert(Collection $FormalEducationHistories)
    {
        return $this->eloquent()->insert($FormalEducationHistories->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function update(FormalEducationHistoryInterface $FormalEducationHistory)
    {
        $data = $this->setupPayload($FormalEducationHistory);
       
        return $this->eloquent()->update($data, $FormalEducationHistory->getKey());
    }

    /**
     * @param FormalEducationHistoryInterface $FormalEducationHistory
     * @param array $params
     * @return mixed
     */
    public function updateOrCreate(FormalEducationHistoryInterface $FormalEducationHistory, array $params)
    {
        $data = $this->setupPayload($FormalEducationHistory);

        return $this->eloquent()->updateOrCreate($data, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(FormalEducationHistoryInterface $FormalEducationHistory)
    {
        return $this->eloquent()->delete($FormalEducationHistory->getKey());
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
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @return mixed
     */
    public function formalEducationHistoryList(int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if ($degreeId != null) {
            $this->eloquent->findWhereByDegreeId($degreeId);
        }

        if ($majorId != null) {
            $this->eloquent->findWhereByMajorId($majorId);
        }

        // start and end date
        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        return $this->eloquent->with(['employee' => function($query) {
            return $query->with(['company']);
        }])->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function formalEducationHistoryListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null, bool $count = false)
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

        if ($degreeId != null) {
            $this->eloquent->findWhereByDegreeId($degreeId);
        }

        if ($majorId != null) {
            $this->eloquent->findWhereByMajorId($majorId);
        }

        // start and end date
        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }, 'degree', 'major'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $degreeId
     * @param int|null $majorId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function formalEducationHistoryPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $degreeId = null, int $majorId = null, DateTime $date = null, bool $count = false)
    {
        if ($companyId != null) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if ($employeeId != null) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if ($degreeId != null) {
            $this->eloquent->findWhereByDegreeId($degreeId);
        }

        if ($majorId != null) {
            $this->eloquent->findWhereByMajorId($majorId);
        }

        // start and end date
        if ($date != null) {
            $this->eloquent->findWhereDateByDate($date);
        }

        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'degree', 'major'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'degree', 'major'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
