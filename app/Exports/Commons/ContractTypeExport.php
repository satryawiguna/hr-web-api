<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContractTypeExport implements FromView
{
    public function __construct($contractTypes)
    {
        $this->contractTypes = $contractTypes;
    }

    public function view(): View
    {
        return view('exports.commons.contract-type', [
            'contractTypes' => $this->contractTypes
        ]);
    }
}
