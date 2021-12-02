<?php
namespace App\Domains\User\Contracts;


use App\Domains\Contracts\BaseEntityInterface;

interface UserInterface extends BaseEntityInterface
{
    //<editor-fold desc="#constanta">

    const TABLE_NAME = 'users';
    const MORPH_NAME = 'users';

    //</editor-fold>


    //<editor-fold desc="#property">

    /**
     * Get username.
     *
     * @return mixed
     */
    public function getUsername();

    /**
     * Set username.
     *
     * @param $username
     *
     * @return mixed
     */
    public function setUsername($username);

    /**
     * Get email.
     *
     * @return mixed
     */
    public function getEmail();

    /**
     * Set email.
     *
     * @param $email
     *
     * @return mixed
     */
    public function setEmail($email);

    /**
     * Get password.
     *
     * @return mixed
     */
    public function getPassword();

    /**
     * Set password.
     *
     * @param $password
     *
     * @return mixed
     */
    public function setPassword($password);

    /**
     * Get remember_token.
     *
     * @return mixed
     */
    public function getRememberToken();

    /**
     * Set remember_token.
     *
     * @param $remember_token
     *
     * @return mixed
     */
    public function setRememberToken($remember_token);

    /**
     * Get is_active.
     *
     * @return mixed
     */
    public function getIsActive();

    /**
     * Set is_active.
     *
     * @param $is_active
     *
     * @return mixed
     */
    public function setIsActive($is_active);

    /**
     * Get is_block.
     *
     * @return mixed
     */
    public function getIsBlock();

    /**
     * Set is_active.
     *
     * @param $is_block
     *
     * @return mixed
     */
    public function setIsBlock($is_block);

    /**
     * Get created_by.
     *
     * @return mixed
     */
    public function getCreatedBy();

    /**
     * Set created_by.
     *
     * @param $created_by
     *
     * @return mixed
     */
    public function setCreatedBy($created_by);

    /**
     * Get modified_by.
     *
     * @return mixed
     */
    public function getModifiedBy();

    /**
     * Set modified_by.
     *
     * @param $modified_by
     *
     * @return mixed
     */
    public function setModifiedBy($modified_by);

    //</editor-fold>


    //<editor-fold desc="#public (method)">


    //<editor-fold desc="#belongs to many relation">

    /**
     * @return mixed
     */
    public function companies();

    /**
     * @return mixed
     */
    public function applications();

    /**
     * @return mixed
     */
    public function groups();

    /**
     * @return mixed
     */
    public function roles();

    /**
     * @return mixed
     */
    public function permissions();

    /**
     * @return mixed
     */
    public function accesses();

    //</editor-fold>


    //<editor-fold desc="#has one relation">


    /**
     * @return mixed
     */
    public function profile();

    //</editor-fold>


    /**
     * @param $username
     * @return mixed
     */
    public function findForPassport($username);

    /**
     * @param string $role
     * @param $user
     * @return mixed
     */
    public function hasRole($user, string $role);


    //</editor-fold>
}
