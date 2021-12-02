<?php
namespace App\Domains\Commons\VacancyLocation\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface VacancyLocationInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'vacancy_locations';
    const MORPH_NAME = 'vacancy_locations';

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

    /**
     * Get country.
     *
     * @return mixed
     */
    public function getCountry();
    
    /**
     * Set country.
     *
     * @param $country
     *
     * @return mixed
     */
    public function setCountry($country);

    /**
     * Get _lft.
     *
     * @return mixed
     */
    public function getLft();
    
    /**
     * Set _lft.
     *
     * @param $_lft
     *
     * @return mixed
     */
    public function setLft($_lft);

    /**
     * Get _rgt.
     *
     * @return mixed
     */
    public function getRgt();
    
    /**
     * Set _rgt.
     *
     * @param $_rgt
     *
     * @return mixed
     */
    public function setRgt($_rgt);

    /**
     * Get parent_id.
     *
     * @return mixed
     */
    public function getParentId();
    
    /**
     * Set parent_id.
     *
     * @param $parent_id
     *
     * @return mixed
     */
    public function setParentId($parent_id);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to relation">

    /**
     * @return mixed
     */
    public function vacancyLocationParent();

    //</editor-fold>


    //<editor-fold desc="#has many relation">

    /**
     * @return mixed
     */
    public function vacancy();

    /**
     * @return mixed
     */
    public function vacancyLocationChilds();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();


    //</editor-fold>
}
