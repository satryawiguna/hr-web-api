<?php
namespace App\Infrastructures\Area\Country;

use App\Infrastructures\Area\Country\Contracts\EloquentCountryRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;

/**
 * EloquentCountryRepository Class.
 */
class EloquentCountryRepository extends EloquentRepositoryAbstract implements EloquentCountryRepositoryInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * @param string $countryName
     * @return $this|mixed
     */
    public function findWereByCountryName(string $countryName)
    {
        $this->model = $this->model->where('country_name', 'like', '%' . $countryName . '%');

        return $this;
    }

    /**
     * @param string $twoLetterCode
     * @return $this|mixed
     */
    public function findWereByTwoLetterCode(string $twoLetterCode)
    {
        $this->model = $this->model->where('two_letter_code', 'like', '%' . $twoLetterCode . '%');

        return $this;
    }

    /**
     * @param string $searchQuery
     * @return $this|mixed
     */
    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'phone_code' => '%' . $searchQuery . '%'
        ];

        $this->model = $this->model->whereRaw('(phone_code LIKE ?)', $searchParameter);

        return $this;
    }

    //</editor-fold>
}
