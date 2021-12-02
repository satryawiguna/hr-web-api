<?php

namespace App\Exports\HumanResources\Element;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ElementEntryValueExport implements FromView
{
    public function __construct($elementEntryValues)
    {
        $this->elementEntryValues = $elementEntryValues;
    }

    public function view(): View
    {
        return view('exports.human-resources.element.element-entry-value', [
            'elementEntryValues' => $this->elementEntryValues
        ]);
    }
}
