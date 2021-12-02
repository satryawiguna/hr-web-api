<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 7/31/18
 * Time: 10:23 AM
 */

namespace App\Core\Domains\Contracts\Pagination;


class ListedSearchParameter
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