<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GenderExport implements FromView
{
    public function __construct($genders)
    {
        $this->genders = $genders;
    }

    public function view(): View
    {
        return view('exports.commons.gender', [
            'genders' => $this->genders
        ]);
    }
}
