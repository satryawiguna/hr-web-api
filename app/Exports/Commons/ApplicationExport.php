<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ApplicationExport implements FromView
{
    public function __construct($applications)
    {
        $this->applications = $applications;
    }

    public function view(): View
    {
        return view('exports.commons.application', [
            'applications' => $this->applications
        ]);
    }
}
