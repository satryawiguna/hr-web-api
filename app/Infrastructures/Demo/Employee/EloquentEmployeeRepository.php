<?php


namespace App\Infrastructures\Demo\Employee;


use App\Infrastructures\Demo\Employee\Contracts\EloquentEmployeeRepositoryInterface;
use App\Infrastructures\EloquentRepositoryAbstract;
use DateTime;
use Illuminate\Support\Facades\Config;

class EloquentEmployeeRepository extends EloquentRepositoryAbstract implements EloquentEmployeeRepositoryInterface
{
    public function findWhereBetweenByRangeBirthDate(DateTime $startBirthDate, DateTime $endBirthDate)
    {
        $this->model = $this->model->whereBetween('birth_date', [
            $startBirthDate->format(Config::get('datetime.format.default')),
            $endBirthDate->format(Config::get('datetime.format.default'))
        ]);

        return $this;
    }

    public function findWhereBySearchQuery(string $searchQuery)
    {
        $searchParameter = [
            'nip' => '%' . $searchQuery . '%',
            'full_name' => '%' . $searchQuery . '%',
            'nick_name' => '%' . $searchQuery . '%',
            'address' => '%' . $searchQuery . '%',
            'phone' => '%' . $searchQuery . '%',
            'mobile' => '%' . $searchQuery . '%',
            'email' => '%' . $searchQuery . '%',
        ];

        $this->model = $this->model->whereRaw('(nip LIKE ?
            OR full_name LIKE ?
            OR nick_name LIKE ?
            OR address LIKE ?
            OR phone LIKE ?
            OR mobile LIKE ?
            OR email LIKE ?)', $searchParameter);

        return $this;
    }
}