<?php
namespace App\Domains\Commons\Country\Contracts;


use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Response\GenericListSearchResponse;

interface CountryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CountryServiceInterface constructor.
     */
    public function __construct();

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    public function countryListSearch(ListSearchRequest $listSearchRequest, string $alpha_two_code = null): GenericListSearchResponse;

    //</editor-fold>
}
