<?php

namespace App\Exports\HumanResources\Element;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ElementEntryExport implements FromView
{
    public function __construct($elementEntries)
    {
        $this->elementEntries = $elementEntries;
    }

    public function view(): View
    {
        return view('exports.human-resources.element.element-entry', [
            'elementEntries' => $this->elementEntries
        ]);
    }
}
