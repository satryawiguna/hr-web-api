<?php

namespace App\Domains\HumanResources\MasterData\BaseSalaryCustomType;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\BaseSalaryCustomType\Contracts\EloquentBaseSalaryCustomTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\BaseSalaryCustomType\Contracts\BaseSalaryCustomTypeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class BaseSalaryCustomTypeRepository.
 */
class BaseSalaryCustomTypeRepository extends RepositoryAbstract implements BaseSalaryCustomTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * BaseSalaryCustomTypeRepository constructor.
     *
     * @param EloquentBaseSalaryCustomTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentBaseSalaryCustomTypeRepositoryInterface $eloquent)
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
    public function setupPayload(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        return [
            'company_id' => $BaseSalaryCustomType->getCompanyId(),
            'name' => $BaseSalaryCustomType->getName(),
            'slug' => $BaseSalaryCustomType->getSlug(),
            'description' => $BaseSalaryCustomType->getDescription(),
            'is_active' => (!is_null($BaseSalaryCustomType->getIsActive())) ? $BaseSalaryCustomType->getIsActive() : 0,
            'created_by' => $BaseSalaryCustomType->getCreatedBy(),
            'modified_by' => $BaseSalaryCustomType->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        $data = $this->setupPayload($BaseSalaryCustomType);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        $data = $this->setupPayload($BaseSalaryCustomType);
       
        return $this->eloquent()->update($data, $BaseSalaryCustomType->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(BaseSalaryCustomTypeInterface $BaseSalaryCustomType)
    {
        return $this->eloquent()->delete($BaseSalaryCustomType->getKey());
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
     * @param int|null $isActive
     * @return mixed
     */
    public function baseSalaryCustomTypeList(int $companyId = null, int $isActive = null)
    {
        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $companyId
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function baseSalaryCustomTypeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
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
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function baseSalaryCustomTypePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if (!is_null($companyId)) {
            $this->eloquent->findWhereByCompanyId($companyId);
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
