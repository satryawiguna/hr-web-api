<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NonFormalEducationExport implements FromView
{
    public function __construct($nonFormalEducationHistories)
    {
        $this->nonFormalEducationHistories = $nonFormalEducationHistories;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.non-formal-education-history', [
            'nonFormalEducationHistories' => $this->nonFormalEducationHistories
        ]);
    }
}
