<?php

namespace App\Infrastructures;


use App\Core\Services\Request\AuditableRequest;
use Illuminate\Support\Facades\Config;

abstract class EloquentAbstract extends AuditableRequest
{
    //<editor-fold desc="#field">

    protected $primaryKey = 'id';

    //</editor-fold>


    //<editor-fold desc="#public (method)">

    /**
     * Get Primary Key.
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * Get Created At.
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at->format(Config::get('datetime.format.database_datetime'));
    }

    /**
     * Get Updated At.
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at->format(Config::get('datetime.format.database_datetime'));
    }

    /**
     * Get Deleted At.
     */
    public function getDeletedAt()
    {
        if (!$this->deleted_at) {
            return null;
        }

        return $this->deleted_at->format(Config::get('datetime.format.database_datetime'));
    }

    //</editor-fold>
}
