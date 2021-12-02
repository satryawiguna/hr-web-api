<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:16 PM
 */

namespace App\Core\Services\Response;


use Illuminate\Database\Eloquent\Collection;

class GenericCollectionResponse extends BasicResponse
{
    private $_dtoList;

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
}