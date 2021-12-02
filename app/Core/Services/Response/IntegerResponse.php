<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:18 PM
 */

namespace App\Core\Services\Response;


class IntegerResponse extends BasicResponse
{
    public $_result;

    /**
     * @return int
     */
    public function getInteger(): int
    {
        return $this->_result ?? $this->_result = (int)0;
    }

    /**
     * @return mixed
     */
    public function getResult(): int
    {
        return $this->_result;
    }

    /**
     * @param mixed $result
     */
    public function setResult(int $result): void
    {
        $this->_result = $result;
    }


}