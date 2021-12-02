<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FormalEducationExport implements FromView
{
    public function __construct($formalEducationHistories)
    {
        $this->formalEducationHistories = $formalEducationHistories;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.formal-education-history', [
            'formalEducationHistories' => $this->formalEducationHistories
        ]);
    }
}
