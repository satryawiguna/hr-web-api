<?php
/**
 * Created by PhpStorm.
 * User: satryawiguna
 * Date: 4/3/18
 * Time: 5:00 AM
 */

namespace App\Core\Services\Request;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AuditableRequest extends Authenticatable
{
    public $request_by;

    /**
     * Get request by.
     * @return mixed
     */
    public function getRequestBy()
    {
        return $this->request_by;
    }

    /**
     * Set request by.
     * @param mixed $request_by
     */
    public function setRequestBy($request_by): void
    {
        $this->request_by = $request_by;
    }
}