<?php

namespace App\Domains\Commons\VacancyLocation;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Commons\VacancyLocation\Contracts\VacancyLocationRepositoryInterface;
use App\Infrastructures\Commons\VacancyLocation\Contracts\EloquentVacancyLocationRepositoryInterface;
use App\Domains\Commons\VacancyLocation\Contracts\VacancyLocationInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class VacancyLocationRepository.
 */
class VacancyLocationRepository extends RepositoryAbstract implements VacancyLocationRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * VacancyLocationRepository constructor.
     *
     * @param EloquentVacancyLocationRepositoryInterface $eloquent
     */
    public function __construct(EloquentVacancyLocationRepositoryInterface $eloquent)
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
    public function setupPayload(VacancyLocationInterface $VacancyLocation)
    {
        return [
            'name' => $VacancyLocation->getName(),
            'slug' => $VacancyLocation->getSlug(),
            'country' => $VacancyLocation->getCountry(),
            '_lft' => $VacancyLocation->getLft(),
            '_rgt' => $VacancyLocation->getRgt(),
            'parent_id' => $VacancyLocation->getParentId(),
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(VacancyLocationInterface $VacancyLocation)
    {
        $data = $this->setupPayload($VacancyLocation);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(VacancyLocationInterface $VacancyLocation)
    {
        $data = $this->setupPayload($VacancyLocation);
       
        return $this->eloquent()->update($data, $VacancyLocation->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(VacancyLocationInterface $VacancyLocation)
    {
        return $this->eloquent()->delete($VacancyLocation->getKey());
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
     * @return mixed
     */
    public function vacancyLocationList(int $parentId = null)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param bool|null $count
     * @return mixed
     */
    public function vacancyLocationListSearch(ListedSearchParameter $parameter, int $parentId = null, bool $count = null)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param bool $count
     * @return mixed
     */
    public function vacancyLocationPageSearch(PagedSearchParameter $parameter, int $parentId = null, bool $count = false)
    {
        if (!is_null($parentId)) {
            $this->eloquent->findWhereByParentId($parentId);
        }
        
        $searchQuery = !is_null($parameter->search) ? $parameter->search['value'] : $parameter->query['value'] ?? null;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
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