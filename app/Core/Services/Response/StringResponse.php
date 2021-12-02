<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:18 PM
 */

namespace App\Core\Services\Response;


class StringResponse extends BasicResponse
{
    public $_result;

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->_result ?? $this->_result = (string)"";
    }

    /**
     * @return mixed
     */
    public function getResult(): string
    {
        return $this->_result;
    }

    /**
     * @param mixed $result
     */
    public function setResult(string $result): void
    {
        $this->_result = $result;
    }


}