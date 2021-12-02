<?php

namespace App\Exports\HumanResources\Project;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectAddendumExport implements FromView
{
    public function __construct($projectAddendums)
    {
        $this->projectAddendums = $projectAddendums;
    }

    public function view(): View
    {
        return view('exports.human-resources.project.project-addendum', [
            'projectAddendums' => $this->projectAddendums
        ]);
    }
}
