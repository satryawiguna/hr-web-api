<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/3/18
 * Time: 10:53 AM
 */

namespace App\Core\Domains\Contracts\Pagination;


use Illuminate\Support\Collection;

class PageSearchResult
{
    private $_resultList;

    public $_resultCollection;

    public $_count;

    /**
     * PageSearchResult constructor.
     */
    public function __construct()
    {
        $this->_resultList = new Collection();

        $this->_resultCollection = new Collection();
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count): void
    {
        $this->_count = $count;
    }

    /**
     * @return Collection
     */
    public function getResultCollection(): Collection
    {
        return $this->_resultList ?? $this->_resultList = new Collection();
    }

}