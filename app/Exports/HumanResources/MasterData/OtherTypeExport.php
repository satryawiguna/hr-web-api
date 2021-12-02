<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OtherTypeExport implements FromView
{
    public function __construct($otherTypes)
    {
        $this->otherTypes = $otherTypes;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.other-type', [
            'otherTypes' => $this->otherTypes
        ]);
    }
}
