<?php

namespace App\Domains\Commons\VacancyCategory\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface VacancyCategoryInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'vacancy_categories';
    const MORPH_NAME = 'vacancy_categories';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get name.
     *
     * @return mixed
     */
    public function getName();

    /**
     * Set name.
     *
     * @param $name
     *
     * @return mixed
     */
    public function setName($name);

    /**
     * Get slug.
     *
     * @return mixed
     */
    public function getSlug();

    /**
     * Set slug.
     *
     * @param $slug
     *
     * @return mixed
     */
    public function setSlug($slug);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function vacancy();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();


    //</editor-fold>
}
