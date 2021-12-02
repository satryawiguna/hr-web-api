<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DegreeExport implements FromView
{
    public function __construct($degrees)
    {
        $this->degrees = $degrees;
    }

    public function view(): View
    {
        return view('exports.commons.degree', [
            'degrees' => $this->degrees
        ]);
    }
}
