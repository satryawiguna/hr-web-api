<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 7/31/18
 * Time: 9:59 AM
 */

namespace App\Core\Services\Request;


class ListSearchRequest
{
    public $query;

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }
}