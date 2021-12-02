<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BankExport implements FromView
{
    public function __construct($banks)
    {
        $this->banks = $banks;
    }

    public function view(): View
    {
        return view('exports.commons.bank', [
            'banks' => $this->banks
        ]);
    }
}
