<?php

namespace App\Domains\Commons\ContractType;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\ContractType\Contracts\ContractTypeRepositoryInterface;
use App\Infrastructures\Commons\ContractType\Contracts\EloquentContractTypeRepositoryInterface;
use App\Domains\Commons\ContractType\Contracts\ContractTypeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class ContractTypeRepository.
 */
class ContractTypeRepository extends RepositoryAbstract implements ContractTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * ContractTypeRepository constructor.
     *
     * @param EloquentContractTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentContractTypeRepositoryInterface $eloquent)
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
    public function setupPayload(ContractTypeInterface $ContractType)
    {
        return [
            'name' => $ContractType->getName(),
            'slug' => $ContractType->getSlug(),
            'description' => $ContractType->getDescription(),
            'is_active' => (!is_null($ContractType->getIsActive())) ? $ContractType->getIsActive() : 0,
            'created_by' => $ContractType->getCreatedBy(),
            'modified_by' => $ContractType->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContractTypeInterface $ContractType)
    {
        $data = $this->setupPayload($ContractType);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(ContractTypeInterface $ContractType)
    {
        $data = $this->setupPayload($ContractType);
       
        return $this->eloquent()->update($data, $ContractType->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(ContractTypeInterface $ContractType)
    {
        return $this->eloquent()->delete($ContractType->getKey());
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
     * @param int|null $isActive
     * @return mixed
     */
    public function contractTypeList(int $isActive = null)
    {
        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function contractTypeListSearch(ListedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $isActive
     * @param bool $count
     * @return mixed
     */
    public function contractTypePageSearch(PagedSearchParameter $parameter, int $isActive = null, bool $count = false)
    {
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($isActive)) {
            $this->eloquent->findWhereByIsActive($isActive);
        }

        if (!$count) {
            if ($parameter->draw) {
                return $this->eloquent->orderBy($parameter->columns[$parameter->order[0]['column']]['data'], $parameter->order[0]['dir'])
                    ->paginate($parameter->length, $parameter->start);
            } else {
                return $this->eloquent->orderBy($parameter->sort['field'], $parameter->sort['sort'])
                    ->paginate($parameter->pagination['perpage'], ($parameter->pagination['perpage'] * ($parameter->pagination['page'] - 1)));
            }
        } else {
            return $this->eloquent->all()->count();
        }

    }

    //</editor-fold>
}
