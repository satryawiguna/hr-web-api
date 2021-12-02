<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReligionExport implements FromView
{
    public function __construct($religions)
    {
        $this->religions = $religions;
    }

    public function view(): View
    {
        return view('exports.commons.religion', [
            'religions' => $this->religions
        ]);
    }
}
