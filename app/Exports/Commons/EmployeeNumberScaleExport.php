<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeNumberScaleExport implements FromView
{
    public function __construct($employeeNumberScales)
    {
        $this->employeeNumberScales = $employeeNumberScales;
    }

    public function view(): View
    {
        return view('exports.commons.employee-number-scale', [
            'employeeNumberScales' => $this->employeeNumberScales
        ]);
    }
}
