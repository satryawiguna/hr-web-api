<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GradeExport implements FromView
{
    public function __construct($grades)
    {
        $this->grades = $grades;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.competence', [
            'grades' => $this->grades
        ]);
    }
}
