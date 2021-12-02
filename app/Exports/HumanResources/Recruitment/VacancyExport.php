<?php

namespace App\Exports\HumanResources\Recruitment;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VacancyExport implements FromView
{
    public function __construct($vacancies)
    {
        $this->vacancies = $vacancies;
    }

    public function view(): View
    {
        return view('exports.human-resources.recruitment.vacancies', [
            'vacancies' => $this->vacancies
        ]);
    }
}
