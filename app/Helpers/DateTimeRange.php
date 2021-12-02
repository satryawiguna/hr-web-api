<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 1/12/20
 * Time: 10:20 PM
 */

namespace App\Helpers;


use DateTime;

class DateTimeRange
{
    public $start;

    public $end;

    /**
     * RangeDate constructor.
     * @param $start
     * @param $end
     */
    public function __construct($start, $end)
    {
        $this->start = ($start && DateTime::createFromFormat('Y-m-d H:i:s', $start) !== false) ? new DateTime($start) : null;
        $this->end = ($end && DateTime::createFromFormat('Y-m-d H:i:s', $end) !== false) ? new DateTime($end) : null;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart($start): void
    {
        $this->start = $start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param mixed $end
     */
    public function setEnd($end): void
    {
        $this->end = $end;
    }
}