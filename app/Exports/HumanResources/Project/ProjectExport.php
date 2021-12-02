<?php

namespace App\Exports\HumanResources\Project;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectExport implements FromView
{
    public function __construct($projects)
    {
        $this->projects = $projects;
    }

    public function view(): View
    {
        return view('exports.human-resources.project.project', [
            'projects' => $this->projects
        ]);
    }
}
