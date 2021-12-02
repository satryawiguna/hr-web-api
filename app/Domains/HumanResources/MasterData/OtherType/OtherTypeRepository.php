<?php

namespace App\Domains\HumanResources\MasterData\OtherType;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeRepositoryInterface;
use App\Infrastructures\HumanResources\MasterData\OtherType\Contracts\EloquentOtherTypeRepositoryInterface;
use App\Domains\HumanResources\MasterData\OtherType\Contracts\OtherTypeInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class OtherTypeRepository.
 */
class OtherTypeRepository extends RepositoryAbstract implements OtherTypeRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * OtherTypeRepository constructor.
     *
     * @param EloquentOtherTypeRepositoryInterface $eloquent
     */
    public function __construct(EloquentOtherTypeRepositoryInterface $eloquent)
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
    public function setupPayload(OtherTypeInterface $OtherType)
    {
        return [
            'company_id' => $OtherType->getCompanyId(),
            'name' => $OtherType->getName(),
            'slug' => $OtherType->getSlug(),
            'description' => $OtherType->getDescription(),
            'is_active' => (!is_null($OtherType->getIsActive())) ? $OtherType->getIsActive() : 0,
            'created_by' => $OtherType->getCreatedBy(),
            'modified_by' => $OtherType->getModifiedBy(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(OtherTypeInterface $OtherType)
    {
        $data = $this->setupPayload($OtherType);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(OtherTypeInterface $OtherType)
    {
        $data = $this->setupPayload($OtherType);
       
        return $this->eloquent()->update($data, $OtherType->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(OtherTypeInterface $OtherType)
    {
        return $this->eloquent()->delete($OtherType->getKey());
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
    public function otherTypeList(int $companyId = null, int $isActive = null)
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
    public function otherTypeListSearch(ListedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
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
    public function otherTypePageSearch(PagedSearchParameter $parameter, int $companyId = null, int $isActive = null, bool $count = false)
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
