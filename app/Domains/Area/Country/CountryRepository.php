<?php

namespace App\Domains\Area\Country;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Area\Country\Contracts\CountryRepositoryInterface;
use App\Infrastructures\Area\Country\Contracts\EloquentCountryRepositoryInterface;
use App\Domains\Area\Country\Contracts\CountryInterface;
use App\Domains\RepositoryAbstract;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Class CountryRepository.
 */
class CountryRepository extends RepositoryAbstract implements CountryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CountryRepository constructor.
     *
     * @param EloquentCountryRepositoryInterface $eloquent
     */
    public function __construct(EloquentCountryRepositoryInterface $eloquent)
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
    public function setupPayload(CountryInterface $Country)
    {
        return [
            'country_name' => $Country->getCountryName(),
            'two_letter_code' => $Country->getTwoLetterCode(),
            'phone_code' => $Country->getPhoneCode()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function create(CountryInterface $Country)
    {
        $data = $this->setupPayload($Country);

        return $this->eloquent()->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function update(CountryInterface $Country)
    {
        $data = $this->setupPayload($Country);

        return $this->eloquent()->update($data, $Country->getKey());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(CountryInterface $Country)
    {
        return $this->eloquent()->delete($Country->getKey());
    }

    /**
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return mixed
     */
    public function countryList(string $countryName = null, string $twoLetterCode = null)
    {
        if (!is_null($countryName)) {
            $this->eloquent->findWereByCountryName($countryName);
        }

        if (!is_null($twoLetterCode)) {
            $this->eloquent->findWereByTwoLetterCode($twoLetterCode);
        }

        return $this->eloquent->all();
    }

    /**
     * @param ListedSearchParameter $parameter
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param bool|null $count
     * @return mixed
     */
    public function countryListSearch(ListedSearchParameter $parameter, string $countryName = null, string $twoLetterCode = null, bool $count = null)
    {
        $searchQuery = $parameter->query;

        if ($searchQuery) {
            $this->eloquent->findWhereBySearchQuery($searchQuery);
        }

        if (!is_null($countryName)) {
            $this->eloquent->findWereByCountryName($countryName);
        }

        if (!is_null($twoLetterCode)) {
            $this->eloquent->findWereByTwoLetterCode($twoLetterCode);
        }

        if (!$count) {
            return $this->eloquent->all();
        } else {
            return $this->eloquent->all()->count();
        }
    }

    /**
     * @param PagedSearchParameter $parameter
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param bool $count
     * @return mixed
     */
    public function countryPageSearch(PagedSearchParameter $parameter, string $countryName = null, string $twoLetterCode = null, bool $count = false)
    {
        if (!is_null($countryName)) {
            $this->eloquent->findWereByCountryName($countryName);
        }

        if (!is_null($twoLetterCode)) {
            $this->eloquent->findWereByTwoLetterCode($twoLetterCode);
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
