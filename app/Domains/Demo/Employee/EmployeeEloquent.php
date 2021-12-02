<?php


namespace App\Domains\Demo\Employee;




use App\Domains\Demo\Employee\Contracts\EmployeeInterface;
use App\Infrastructures\EloquentAbstract;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class EmployeeEloquent extends EloquentAbstract implements EmployeeInterface
{
    use SoftDeletes;

    protected $table = EmployeeInterface::TABLE_NAME;

    protected $primaryKey = 'id';
    protected $fillable = [
        'nip', 'full_name', 'nick_name', 'birth_date', 'address', 'phone', 'mobile', 'email', 'created_by', 'modified_by'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function getNip()
    {
        return $this->nip;
    }

    public function setNip(string $nip)
    {
        $this->nip = $nip;
        return $this;
    }

    public function getFullName()
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name)
    {
        $this->full_name = $full_name;
        return $this;
    }

    public function getNickName()
    {
        return $this->nick_name;
    }

    public function setNickName(string $nick_name)
    {
        $this->nick_name = $nick_name;
        return $this;
    }

    public function getBirthDate()
    {
        return $this->birth_date;
    }

    public function setBirthDate(DateTime $birth_date)
    {
        $this->birth_date = $birth_date->format(Config::get('datetime.format.database_datetime'));
        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function getMobile()
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getCreatedBy()
    {
        return $this->created_by;
    }

    public function setCreatedBy(string $created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    public function setModifiedBy(string $modified_by)
    {
        $this->modified_by = $modified_by;
        return $this;
    }
}