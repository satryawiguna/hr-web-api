<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BaseSalaryCustomTypeExport implements FromView
{
    public function __construct($baseSalaryCustomTypes)
    {
        $this->baseSalaryCustomTypes = $baseSalaryCustomTypes;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.base-salary-custom-type', [
            'baseSalaryCustomTypes' => $this->baseSalaryCustomTypes
        ]);
    }
}
