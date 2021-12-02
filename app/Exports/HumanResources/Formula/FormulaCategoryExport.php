<?php

namespace App\Exports\HumanResources\Formula;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FormulaCategoryExport implements FromView
{
    public function __construct($formulaCategories)
    {
        $this->formulaCategories = $formulaCategories;
    }

    public function view(): View
    {
        return view('exports.human-resources.formula.formula-category', [
            'formulaCategories' => $this->formulaCategories
        ]);
    }
}
