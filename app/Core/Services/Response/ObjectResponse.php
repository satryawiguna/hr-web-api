<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:16 PM
 */

namespace App\Core\Services\Response;


class ObjectResponse extends BasicResponse
{
    private $_result;

    /**
     * @return object
     */
    public function getObject(): object
    {
        return $this->_result ?? $this->_result = (object)[];
    }

    /**
     * @return mixed
     */
    public function getResult(): object
    {
        return $this->_result;
    }

    /**
     * @param $result
     */
    public function setResult(object $result): void
    {
        $this->_result = $result;
    }
}