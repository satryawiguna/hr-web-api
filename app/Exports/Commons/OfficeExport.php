<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OfficeExport implements FromView
{
    public function __construct($offices)
    {
        $this->offices = $offices;
    }

    public function view(): View
    {
        return view('exports.commons.office', [
            'offices' => $this->offices
        ]);
    }
}
