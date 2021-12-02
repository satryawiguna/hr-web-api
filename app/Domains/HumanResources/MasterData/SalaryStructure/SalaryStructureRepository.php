<?php

namespace App\Domains\HumanResources\MasterData\SalaryStructure;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\SalaryStructure\Contracts\EloquentSalaryStructureRepositoryInterface;
use App\Domains\HumanResources\MasterData\SalaryStructure\Contracts\SalaryStructureInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class SalaryStructureRepository.
 */
class SalaryStructureRepository extends RepositoryAbstract implements SalaryStructureRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * SalaryStructureRepository constructor.
     *
     * @param EloquentSalaryStructureRepositoryInterface $eloquent
     */
    public function __construct(EloquentSalaryStructureRepositoryInterface $eloquent)
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
    public function setupPayload(SalaryStructureInterface $SalaryStructure)
    {
        return [
            'company_id' => $SalaryStructure->getCompanyId(),
            'type' => $SalaryStructure->getType(),
            'name' => $SalaryStructure->getName(),
            'slug' => $SalaryStructure->getSlug(),
            'description' => $SalaryStructure->getDescription(),
            'is_active' => (!is_null($SalaryStructure->getIsActive())) ? $SalaryStructure->getIsActive() : 0,
            'created_by' => $SalaryStructure->getCreatedBy(),
            'modified_by' => $SalaryStructure->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(SalaryStructureInterface $SalaryStructure)
    {
        $data = $this->setupPayload($SalaryStructure);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(SalaryStructureInterface $SalaryStructure)
    {
        $data = $this->setupPayload($SalaryStructure);
       
        return $this->eloquent()->update($data, $SalaryStructure->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(SalaryStructureInterface $SalaryStructure)
    {
        return $this->eloquent()->delete($SalaryStructure->getKey());
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
     * @param string|null $type
     * @param int|null $isActive
     * @return mixed
     */
    public function salaryStructureList(int $companyId = null, string $type = null, int $isActive = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function salaryStructureListSearch(ListedSearchParameter $parameter, int $companyId = null, string $type = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->with(['company'])
                ->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $companyId
     * @param string|null $type
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function salaryStructurePageSearch(PagedSearchParameter $parameter, int $companyId = null, string $type = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($type)) {
            $this->eloquent->findWhereByType($type);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->with(['company'])
                    ->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
