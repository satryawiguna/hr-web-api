<?php
namespace App\Domains\User\Contracts\Request;


class LoginRequest
{
    public $email;

    public $username;

    public $password;

    public $remember;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getRemember()
    {
        return $this->remember;
    }

    /**
     * @param mixed $remember
     */
    public function setRemember($remember): void
    {
        $this->remember = $remember;
    }
}