<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{
    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.employee', [
            'employees' => $this->employees
        ]);
    }
}
