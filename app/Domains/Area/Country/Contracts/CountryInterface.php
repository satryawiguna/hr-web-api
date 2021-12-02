<?php

namespace App\Domains\Area\Country\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface CountryInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'countries';
    const MORPH_NAME = 'countries';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get country_name.
     *
     * @return mixed
     */
    public function getCountryName();

    /**
     * Set country_name.
     *
     * @param $country_name
     *
     * @return mixed
     */
    public function setCountryName($country_name);

    /**
     * Get two_letter_code.
     *
     * @return mixed
     */
    public function getTwoLetterCode();

    /**
     * Set two_letter_code.
     *
     * @param $two_letter_code
     *
     * @return mixed
     */
    public function setTwoLetterCode($two_letter_code);

    /**
     * Get phone_code.
     *
     * @return mixed
     */
    public function getPhoneCode();

    /**
     * Set phone_code.
     *
     * @param $phone_code
     *
     * @return mixed
     */
    public function setPhoneCode($phone_code);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function states();

    /**
     * @return mixed
     */
    public function cities();

    //</editor-fold>


    //</editor-fold>
}
