<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PositionMutationExport implements FromView
{
    public function __construct($positionMutations)
    {
        $this->positionMutations = $positionMutations;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.position-mutation', [
            'positionMutations' => $this->positionMutations
        ]);
    }
}
