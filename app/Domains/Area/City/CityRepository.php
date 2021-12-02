<?php

namespace App\Domains\Area\City;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Area\City\Contracts\CityRepositoryInterface;
use App\Infrastructures\Area\City\Contracts\EloquentCityRepositoryInterface;
use App\Domains\Area\City\Contracts\CityInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class CityRepository.
 */
class CityRepository extends RepositoryAbstract implements CityRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CityRepository constructor.
     *
     * @param EloquentCityRepositoryInterface $eloquent
     */
    public function __construct(EloquentCityRepositoryInterface $eloquent)
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
    public function setupPayload(CityInterface $City)
    {
        return [
            'state_id' => $City->getStateId(),
            'city_name' => $City->getCityName()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(CityInterface $City)
    {
        $data = $this->setupPayload($City);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(CityInterface $City)
    {
        $data = $this->setupPayload($City);

        return $this->eloquent()->update($data, $City->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CityInterface $City)
    {
        return $this->eloquent()->delete($City->getKey());
    }

    /**
     * @param int|null $stateId
     * @return mixed
     */
    public function cityList(int $stateId = null)
    {
        if (!is_null($stateId)) {
            $this->eloquent->findWereByStateId($stateId);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param int|null $stateId
     * @param bool|null $count
     * @return mixed
     */
    public function cityListSearch(ListedSearchParameter $parameter, int $stateId = null, bool $count = null)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($stateId)) {
            $this->eloquent->findWereByStateId($stateId);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param int|null $stateId
     * @param bool $count
     * @return mixed
     */
    public function cityPageSearch(PagedSearchParameter $parameter, int $stateId = null, bool $count = false)
    {
        if (!is_null($stateId)) {
            $this->eloquent->findWereByStateId($stateId);
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
