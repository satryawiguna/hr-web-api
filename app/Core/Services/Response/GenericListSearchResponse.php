<?php
namespace App\Core\Services\Response;

use Illuminate\Support\Collection;

class GenericListSearchResponse extends BasicResponse
{
    private $_dtoList;

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
}