<?php
namespace App\Domains\Commons\Skill\Contracts;

use App\Domains\Contracts\BaseEntityInterface;

interface SkillInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'skills';
    const MORPH_NAME = 'skills';

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

    // /**
    //  * @return mixed
    //  */
    // public function vacancy();

    //</editor-fold>


    /**
     * @return mixed
     */
    public function sluggable();


    //</editor-fold>
}
