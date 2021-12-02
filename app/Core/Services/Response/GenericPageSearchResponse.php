<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:17 PM
 */

namespace App\Core\Services\Response;


use Illuminate\Support\Collection;

class GenericPageSearchResponse extends BasicResponse
{
    private $_dtoList;

    private $_totalPage;

    private $_totalCount;

    /**
     * @return Collection
     */
    public function getDtoCollection(): Collection
    {
        return $this->_dtoList ?? $this->_dtoList = new Collection();
    }

    /**
     * @return Collection
     */
    public function getDtoList(): Collection
    {
        return $this->_dtoList;
    }

    /**
     * @param Collection $dtoList
     */
    public function setDtoList(Collection $dtoList): void
    {
        $this->_dtoList = $dtoList;
    }

    /**
     * @return mixed
     */
    public function getTotalCount(): int
    {
        return $this->_totalCount;
    }

    /**
     * @param mixed $totalCount
     */
    public function setTotalCount(int $totalCount): void
    {
        $this->_totalCount = $totalCount;
    }

    /**
     * @return mixed
     */
    public function getTotalPage(): int
    {
        return $this->_totalPage;
    }

    /**
     * @param mixed $totalPage
     */
    public function setTotalPage(int $totalPage): void
    {
        $this->_totalPage = $totalPage;
    }
}