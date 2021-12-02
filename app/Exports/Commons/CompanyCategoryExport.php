<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyCategoryExport implements FromView
{
    public function __construct($companyCategories)
    {
        $this->companyCategories = $companyCategories;
    }

    public function view(): View
    {
        return view('exports.commons.company-category', [
            'companyCategories' => $this->companyCategories
        ]);
    }
}
