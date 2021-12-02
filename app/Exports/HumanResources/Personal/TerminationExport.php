<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TerminationExport implements FromView
{
    public function __construct($terminations)
    {
        $this->terminations = $terminations;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.termination', [
            'terminations' => $this->terminations
        ]);
    }
}
