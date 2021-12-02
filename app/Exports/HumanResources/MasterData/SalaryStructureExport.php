<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalaryStructureExport implements FromView
{
    public function __construct($salaryStructures)
    {
        $this->salaryStructures = $salaryStructures;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.salary-structure', [
            'salaryStructures' => $this->salaryStructures
        ]);
    }
}
