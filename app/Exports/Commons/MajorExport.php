<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MajorExport implements FromView
{
    public function __construct($majors)
    {
        $this->majors = $majors;
    }

    public function view(): View
    {
        return view('exports.commons.major', [
            'majors' => $this->majors
        ]);
    }
}
