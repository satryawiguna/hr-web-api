<?php

namespace App\Domains\Area\State\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface StateInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'states';
    const MORPH_NAME = 'states';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get country_id.
     *
     * @return mixed
     */
    public function getCountryId();

    /**
     * Set country_id.
     *
     * @param $country_id
     *
     * @return mixed
     */
    public function setCountryId($country_id);

    /**
     * Get state_name.
     *
     * @return mixed
     */
    public function getStateName();

    /**
     * Set state_name.
     *
     * @param $state_name
     *
     * @return mixed
     */
    public function setStateName($state_name);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function country();

    //</editor-fold>


    //</editor-fold>
}
