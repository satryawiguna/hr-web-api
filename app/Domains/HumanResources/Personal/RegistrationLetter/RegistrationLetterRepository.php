<?php

namespace App\Domains\RegistrationLetter;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterRepositoryInterface;
use App\Infrastructures\RegistrationLetter\Contracts\EloquentRegistrationLetterRepositoryInterface;
use App\Domains\RegistrationLetter\Contracts\RegistrationLetterInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;
use DateTime;
use Illuminate\Support\Facades\Config;

/**
 * Class RegistrationLetterRepository.
 */
class RegistrationLetterRepository extends RepositoryAbstract implements RegistrationLetterRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * RegistrationLetterRepository constructor.
     *
     * @param EloquentRegistrationLetterRepositoryInterface $eloquent
     */
    public function __construct(EloquentRegistrationLetterRepositoryInterface $eloquent)
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
    public function setupPayload(RegistrationLetterInterface $RegistrationLetter)
    {
        return [
            'employee_id' => $RegistrationLetter->getEmployeeId(),
            'letter_type_id' => $RegistrationLetter->getLetterTypeId(),
            'reference_number' => $RegistrationLetter->getReferenceNumber(),
            'start_date' => (!is_null($RegistrationLetter->getStartDate())) ? $RegistrationLetter->getStartDate()->format(Config::get('datetime.format.default')) : null,
            'end_date' => (!is_null($RegistrationLetter->getEndDate())) ? $RegistrationLetter->getEndDate()->format(Config::get('datetime.format.default')) : null,
            'description' => $RegistrationLetter->getDescription(),
            'created_by' => $RegistrationLetter->getCreatedBy(),
            'modified_by' => $RegistrationLetter->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(RegistrationLetterInterface $RegistrationLetter, array $relations = null)
    {
        $data = $this->setupPayload($RegistrationLetter);

        return $this->eloquent()->create($data, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function update(RegistrationLetterInterface $RegistrationLetter, array $relations = null)
    {
        $data = $this->setupPayload($RegistrationLetter);
       
        return $this->eloquent()->update($data, $RegistrationLetter->getKey(), $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(RegistrationLetterInterface $RegistrationLetter)
    {
        return $this->eloquent()->delete($RegistrationLetter->getKey());
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
     * @param int|null $letterTypeId
     * @param DateTime|null $date
     * @return mixed
     */
    public function registrationLetterList(int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null)
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
    public function registrationLetterListSearch(ListedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false)
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
    public function registrationLetterPageSearch(PagedSearchParameter $parameter, int $companyId = null, int $employeeId = null, int $letterTypeId = null, DateTime $date = null, bool $count = false)
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

        if (!is_null($letterTypeId)) {
            $this->eloquent->findWhereByLetterTypeId($letterTypeId);
        }

        if (!is_null($date)) {
            $this->eloquent->findWhereDateByDate($date);
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
