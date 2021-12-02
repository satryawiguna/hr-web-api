<?php

namespace App\Exports\HumanResources\Element;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ElementValueExport implements FromView
{
    public function __construct($elementValues)
    {
        $this->elementValues = $elementValues;
    }

    public function view(): View
    {
        return view('exports.human-resources.element.element-value', [
            'elementValues' => $this->elementValues
        ]);
    }
}
