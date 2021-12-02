<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LetterTypeExport implements FromView
{
    public function __construct($letterTypes)
    {
        $this->letterTypes = $letterTypes;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.letter-type', [
            'letterTypes' => $this->letterTypes
        ]);
    }
}
