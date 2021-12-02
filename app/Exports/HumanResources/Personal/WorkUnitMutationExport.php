<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkUnitMutationExport implements FromView
{
    public function __construct($workUnitMutations)
    {
        $this->workUnitMutations = $workUnitMutations;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.work-unit-mutation', [
            'workUnitMutations' => $this->workUnitMutations
        ]);
    }
}
