<?php

namespace App\Exports\HumanResources\Formula;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FormulaExport implements FromView
{
    public function __construct($formulas)
    {
        $this->formulas = $formulas;
    }

    public function view(): View
    {
        return view('exports.human-resources.formula.formula', [
            'formulas' => $this->formulas
        ]);
    }
}
