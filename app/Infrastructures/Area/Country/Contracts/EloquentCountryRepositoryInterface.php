<?php

namespace App\Infrastructures\Area\Country\Contracts;

use App\Infrastructures\Contracts\EloquentRepositoryInterface;

interface EloquentCountryRepositoryInterface extends EloquentRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $countryName
     * @return mixed
     */
    public function findWereByCountryName(string $countryName);

    /**
     * @param string $twoLetterCode
     * @return mixed
     */
    public function findWereByTwoLetterCode(string $twoLetterCode);

    /**
     * @param string $searchQuery
     * @return mixed
     */
    public function findWhereBySearchQuery(string $searchQuery);

    //</editor-fold>
}
