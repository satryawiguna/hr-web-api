<?php

namespace App\Domains\Area\Country\Contracts;

use App\Core\Services\Request\ListSearchRequest;
use App\Core\Services\Request\PageSearchRequest;
use App\Core\Services\Response\BasicResponse;
use App\Core\Services\Response\GenericCollectionResponse;
use App\Core\Services\Response\GenericListSearchResponse;
use App\Core\Services\Response\ObjectResponse;
use App\Core\Services\Response\GenericPageSearchResponse;

/**
 * Interface CountryServiceInterface.
 */
interface CountryServiceInterface
{
    //<editor-fold desc="#constructor">

    /**
     * CountryServiceInterface constructor.
     *
     * @param CountryRepositoryInterface $repository
     */
    public function __construct(CountryRepositoryInterface $repository);

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Create Country.
     *
     * @param CountryInterface $Country
     *
     * @return mixed
     */
    public function create(CountryInterface $Country): ObjectResponse;

    /**
     * Update Country.
     *
     * @param CountryInterface $Country
     *
     * @return mixed
     */
    public function update(CountryInterface $Country): BasicResponse;

    /**
     * Delete Country.
     *
     * @param CountryInterface $Country
     *
     * @return mixed
     */
    public function delete(CountryInterface $Country): BasicResponse;

    /**
     * @param int $id
     * @return ObjectResponse
     */
    public function find(int $id): ObjectResponse;

    /**
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return GenericCollectionResponse
     */
    public function countryList(string $countryName = null, string $twoLetterCode = null): GenericCollectionResponse;

    /**
     * @param ListSearchRequest $request
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return GenericListSearchResponse
     */
    public function countryListSearch(ListSearchRequest $request, string $countryName = null, string $twoLetterCode = null): GenericListSearchResponse;

    /**
     * @param PageSearchRequest $request
     * @param string|null $countryName
     * @param string|null $twoLetterCode
     * @return GenericPageSearchResponse
     */
    public function countryPageSearch(PageSearchRequest $request, string $countryName = null, string $twoLetterCode = null): GenericPageSearchResponse;

    //</editor-fold>
}
