<?php

namespace App\Domains\WorkAgreementLetter;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterRepositoryInterface;
use App\Infrastructures\WorkAgreementLetter\Contracts\EloquentWorkAgreementLetterRepositoryInterface;
use App\Domains\WorkAgreementLetter\Contracts\WorkAgreementLetterInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Class WorkAgreementLetterRepository.
 */
class WorkAgreementLetterRepository extends RepositoryAbstract implements WorkAgreementLetterRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * WorkAgreementLetterRepository constructor.
     *
     * @param EloquentWorkAgreementLetterRepositoryInterface $eloquent
     */
    public function __construct(EloquentWorkAgreementLetterRepositoryInterface $eloquent)
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
    public function setupPayload(WorkAgreementLetterInterface $WorkAgreementLetter)
    {
        return [
            'employee_id' => $WorkAgreementLetter->getEmployeeId(),
            'letter_type_id' => $WorkAgreementLetter->getLetterTypeId(),
            'reference_number' => $WorkAgreementLetter->getReferenceNumber(),
            'start_date' => (!is_null($WorkAgreementLetter->getStartDate())) ? $WorkAgreementLetter->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($WorkAgreementLetter->getEndDate())) ? $WorkAgreementLetter->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'description' => $WorkAgreementLetter->getDescription(),
            'created_by' => $WorkAgreementLetter->getCreatedBy(),
            'modified_by' => $WorkAgreementLetter->getModifiedBy()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(WorkAgreementLetterInterface $WorkAgreementLetter, array $relations = null)
    {
        $data = $this->setupPayload($WorkAgreementLetter);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(WorkAgreementLetterInterface $WorkAgreementLetter, array $relations = null)
    {
        $data = $this->setupPayload($WorkAgreementLetter);
       
        return $this->eloquent()->update($data, $WorkAgreementLetter->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(WorkAgreementLetterInterface $WorkAgreementLetter)
    {
        return $this->eloquent()->delete($WorkAgreementLetter->getKey());
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
     * @param int $employeeId
     * @param int $letterTypeId
     * @param DateTime $date
     * @return mixed
     */
    public function workAgreementLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($letterTypeId)) {
            $this->eloquent->findWhereByLetterTypeId($letterTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
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
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workAgreementLetterListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false)
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

        if (!is_null($letterTypeId)) {
            $this->eloquent->findWhereByLetterTypeId($letterTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
        }

        if (!$count) {
            return $this->eloquent->with(['employee' => function($query) {
                return $query->with(['company']);
            }, 'letterType'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $employeeId
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @param bool $count
     * @return mixed
     */
    public function workAgreementLetterPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($employeeId)) {
            $this->eloquent->findWhereByEmployeeId($employeeId);
        }

        if (!is_null($letterTypeId)) {
            $this->eloquent->findWhereByLetterTypeId($letterTypeId);
        }

        if (!is_null($date)) {
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
                }, 'letterType'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['employee' => function($query) {
                    return $query->with(['company']);
                }, 'letterType'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
