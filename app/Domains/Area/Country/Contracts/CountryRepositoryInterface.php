<?php

namespace App\Domains\Area\Country\Contracts;

use App\Core\Domains\Contracts\Pagination\ListedSearchParameter;
use App\Core\Domains\Contracts\Pagination\PagedSearchParameter;
use App\Domains\Contracts\HasEloquentStorageRepositoryInterface;
use App\Infrastructures\Area\Country\Contracts\EloquentCountryRepositoryInterface;
use App\Domains\Contracts\BaseEntityInterface;
use Closure;

/**
 * Interface CountryRepositoryInterface.
 */
interface CountryRepositoryInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CountryRepositoryInterface constructor.
     *
     * @param EloquentCountryRepositoryInterface $eloquent
     */
    public function __construct(EloquentCountryRepositoryInterface $eloquent);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Country.
     *
     * @param CountryInterface $Country
     *
     * @return mixed
     */
    public function create(CountryInterface $Country);

    /**
     * Update Country.
     *
     * @param CountryInterface $Country
     *
     * @return mixed
     */
    public function update(CountryInterface $Country);

    /**
     * Delete Country.
     *
     * @param CountryInterface $Country
     *
     * @return mixed
     */
    public function delete(CountryInterface $Country);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return mixed
     */
    public function countryList(string $countryName = null, string $twoLetterCode = null);

    /**
     * @param ListedSearchParameter $parameter
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param bool $count
     * @return mixed
     */
    public function countryListSearch(ListedSearchParameter $parameter, string $countryName = null, string $twoLetterCode = null, bool $count = false);

    /**
     * @param PagedSearchParameter $parameter
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @param bool $count
     * @return mixed
     */
    public function countryPageSearch(PagedSearchParameter $parameter, string $countryName = null, string $twoLetterCode = null, bool $count = false);

    //</editor-fold>
}
