<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:16 PM
 */

namespace App\Core\Services\Response;


class BooleanResponse extends BasicResponse
{
    private $_result;

    /**
     * @return bool
     */
    public function getBoolean(): bool
    {
        return $this->_result ?? $this->_result = (boolean)false;
    }

    /**
     * @return mixed
     */
    public function getResult(): bool
    {
        return $this->_result;
    }

    /**
     * @param mixed $result
     */
    public function setResult(bool $result): void
    {
        $this->_result = $result;
    }
}