<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 1/11/20
 * Time: 12:34 PM
 */

namespace App\Core\Services\Response;


class ArrayResponse extends BasicResponse
{
    public $_result;

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->_result ?? $this->_result = [];
    }

    /**
     * @return mixed
     */
    public function getResult(): array
    {
        return $this->_result;
    }

    /**
     * @param mixed $result
     */
    public function setResult(array $result): void
    {
        $this->_result = $result;
    }


}