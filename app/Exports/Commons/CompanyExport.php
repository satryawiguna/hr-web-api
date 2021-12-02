<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyExport implements FromView
{
    public function __construct($companies)
    {
        $this->companies = $companies;
    }

    public function view(): View
    {
        return view('exports.commons.company', [
            'companies' => $this->companies
        ]);
    }
}
