<?php

namespace App\Exports\HumanResources\Mutation;

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
        return view('exports.human-resources.mutation.work-unit-mutation', [
            'workUnitMutations' => $this->workUnitMutations
        ]);
    }
}
