<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/2/18
 * Time: 4:15 PM
 */

namespace App\Core\Services\Response;


use App\Helpers\MessageType;
use Illuminate\Support\Collection;

/**
 * Class BasicResponse
 * @package App\Core\Services\Response
 */
class BasicResponse
{
    private $_messages;


    /**
     * BasicResponse constructor.
     */
    public function __construct()
    {
        $this->_messages = new Collection();
    }

    /**
     * @return Collection
     */
    public function getMessageCollection()
    {
        return $this->_messages ?? $this->_messages = new Collection();
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->_messages;
    }

    /**
     * @param Collection $messages
     */
    public function setMessages(Collection $messages): void
    {
        $this->_messages = $messages;
    }



    /**
     * @param Collection $messages
     * @param $text
     * @param $status
     */
    public function addSuccessMessageResponse(Collection $messages, $text, $status): void
    {
        $messageResponse = new MessageResponse();
        $messageResponse->type = MessageType::SUCCESS;
        $messageResponse->text = $text;
        $messageResponse->status = $status;

        $messages->push($messageResponse);
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return $this->_messages->last()->type === MessageType::SUCCESS;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseSuccessText()
    {
        return  $this->_messages->get('text');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseSuccessText()
    {
        return $this->_messages->first()->text;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseSuccessText()
    {
        return $this->_messages->last()->text;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseSuccessStatus()
    {
        return  $this->_messages->get('status');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseSuccessStatus()
    {
        return $this->_messages->first()->status;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseSuccessStatus()
    {
        return $this->_messages->last()->status;
    }



    /**
     * @param Collection $messages
     * @param $text
     * @param $status
     */
    public function addErrorMessageResponse(Collection $messages, $text, $status): void
    {
        $messageResponse = new MessageResponse();
        $messageResponse->type = MessageType::ERROR;
        $messageResponse->text = $text;
        $messageResponse->status = $status;

        $messages->push($messageResponse);
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->_messages->last()->type === MessageType::ERROR;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseErrorText()
    {
        return $this->_messages->get('text');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseErrorText()
    {
        return $this->_messages->first()->text;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseErrorText()
    {
        return $this->_messages->last()->text;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseErrorStatus()
    {
        return $this->_messages->get('status');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseErrorStatus()
    {
        return $this->_messages->first()->status;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseErrorStatus()
    {
        return $this->_messages->last()->status;
    }



    /**
     * @param Collection $messages
     * @param string $text
     * @param int $status
     */
    public function addInfoMessageResponse(Collection $messages, $text, $status): void
    {
        $messageResponse = new MessageResponse();
        $messageResponse->type = MessageType::INFO;
        $messageResponse->text = $text;
        $messageResponse->status = $status;

        $messages->push($messageResponse);
    }

    /**
     * @return bool
     */
    public function isInfo()
    {
        return $this->_messages->last()->type === MessageType::INFO;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseInfoText()
    {
        return $this->_messages->get('text');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseInfoText()
    {
        return $this->_messages->first()->text;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseInfoText()
    {
        return $this->_messages->last()->text;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseInfoStatus()
    {
        return $this->_messages->get('status');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseInfoStatus()
    {
        return $this->_messages->first()->status;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseInfoStatus()
    {
        return $this->_messages->last()->status;
    }



    /**
     * @param Collection $messages
     * @param string $text
     * @param int $status
     */
    public function addWarningMessageResponse(Collection $messages, $text, $status): void
    {
        $messageResponse = new MessageResponse();
        $messageResponse->type = MessageType::WARNING;
        $messageResponse->text = $text;
        $messageResponse->status = $status;

        $messages->push($messageResponse);
    }

    /**
     * @return bool
     */
    public function isWarning()
    {
        return $this->_messages->last()->type === MessageType::WARNING;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseWarningText()
    {
        return $this->_messages->get('text');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseWarningText()
    {
        return $this->_messages->first()->text;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseWarningText()
    {
        return $this->_messages->last()->text;
    }

    /**
     * @return mixed
     */
    public function getAllMessageResponseWarningStatus()
    {
        return $this->_messages->get('status');
    }

    /**
     * @return mixed
     */
    public function getFirstMessageResponseWarningStatus()
    {
        return $this->_messages->first()->status;
    }

    /**
     * @return mixed
     */
    public function getLastMessageResponseWarningStatus()
    {
        return $this->_messages->last()->status;
    }
}