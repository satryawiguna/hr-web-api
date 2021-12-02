<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MaritalStatusExport implements FromView
{
    public function __construct($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
    }

    public function view(): View
    {
        return view('exports.commons.marital-status', [
            'maritalStatus' => $this->maritalStatus
        ]);
    }
}
