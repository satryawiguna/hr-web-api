<?php
namespace App\Domains\Contracts;

/**
 * Interface BaseEntityInterface.
 */
interface BaseEntityInterface
{
    //<editor-fold desc="#public (method)">

    /**
     * Get key Identifier usually field primary key.
     * @return mixed
     */
    public function getKey();

    /**
     * Get table name.
     * @return mixed
     */
    public function getTable();

    /**
     * Get attribute value.
     * @param $attributeName
     * @return mixed
     */
    public function getAttribute($attributeName);

    /**
     * Set attribute value.
     * @param $attributeName
     * @param $value
     * @return mixed
     */
    public function setAttribute($attributeName, $value);

    /**
     * Cast object to json.
     * @param int $options
     * @return mixed
     */
    public function toJson(int $options = 0);

    /**
     * Cast object to array.
     * @return mixed
     */
    public function toArray();

    //</editor-fold>
}
