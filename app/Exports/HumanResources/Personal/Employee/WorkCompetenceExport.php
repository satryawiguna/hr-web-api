<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkCompetenceExport implements FromView
{
    public function __construct($workCompetences)
    {
        $this->workCompetences = $workCompetences;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.work-competence', [
            'workCompetences' => $this->workCompetences
        ]);
    }
}
