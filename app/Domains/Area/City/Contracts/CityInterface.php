<?php

namespace App\Domains\Area\City\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface CityInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'cities';
    const MORPH_NAME = 'cities';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get state_id.
     *
     * @return mixed
     */
    public function getStateId();

    /**
     * Set state_id.
     *
     * @param $state_id
     *
     * @return mixed
     */
    public function setStateId($state_id);

    /**
     * Get city_name.
     *
     * @return mixed
     */
    public function getCityName();

    /**
     * Set city_name.
     *
     * @param $city_name
     *
     * @return mixed
     */
    public function setCityName($city_name);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function state();

    //</editor-fold>


    //</editor-fold>
}
