<?php

namespace App\Exports\HumanResources\Element;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ElementExport implements FromView
{
    public function __construct($elements)
    {
        $this->elements = $elements;
    }

    public function view(): View
    {
        return view('exports.human-resources.element.element', [
            'elements' => $this->elements
        ]);
    }
}
