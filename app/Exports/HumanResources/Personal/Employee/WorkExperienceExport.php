<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkExperienceExport implements FromView
{
    public function __construct($workExperiences)
    {
        $this->workExperiences = $workExperiences;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.work-experience', [
            'workExperiences' => $this->workExperiences
        ]);
    }
}

