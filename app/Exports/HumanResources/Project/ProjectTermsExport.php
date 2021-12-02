<?php

namespace App\Exports\HumanResources\Project;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectTermsExport implements FromView
{
    public function __construct($projectTerms)
    {
        $this->projectTerms = $projectTerms;
    }

    public function view(): View
    {
        return view('exports.human-resources.project.project-terms', [
            'projectTerms' => $this->projectTerms
        ]);
    }
}
