<?php

namespace App\Exports\HumanResources\Recruitment;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicantExport implements FromView
{
    public function __construct($applicants)
    {
        $this->applicants = $applicants;
    }

    public function view(): View
    {
        return view('exports.human-resources.recruitment.applicants', [
            'applicants' => $this->applicants
        ]);
    }
}
