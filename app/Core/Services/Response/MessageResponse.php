<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:24 PM
 */

namespace App\Core\Services\Response;


use App\Helpers\MessageType;
use phpDocumentor\Reflection\Types\Integer;

class MessageResponse
{
    public $type;

    public $text;

    public $status;

    /**
     * MessageResponse constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getStatus(): integer
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(integer $status): void
    {
        $this->status = $status;
    }
}