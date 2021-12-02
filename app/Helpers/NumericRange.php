<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 1/13/20
 * Time: 5:07 PM
 */

namespace App\Helpers;


class NumericRange
{
    public $start;

    public $end;

    /**
     * NumericRange constructor.
     * @param $start
     * @param $end
     */
    public function __construct($start, $end)
    {
        $this->start = ($start && is_float(floatval($start)) || is_integer(intval($start))) ? $start : null;
        $this->end = ($end && is_float(floatval($end)) || is_integer(intval($end))) ? $end : null;
    }

    /**
     * @return float|int|null
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param float|int|null $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return float|int|null
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param float|int|null $end
     */
    public function setEnd($end): void
    {
        $this->end = $end;
    }
}