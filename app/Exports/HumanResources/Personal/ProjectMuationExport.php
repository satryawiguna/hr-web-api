<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectMuationExport implements FromView
{
    public function __construct($projectMutations)
    {
        $this->projectMutations = $projectMutations;
    }

    public function view(): View
    {
        return view('exports.human-resources.mutation.project-mutation', [
            'projectMutations' => $this->projectMutations
        ]);
    }
}
