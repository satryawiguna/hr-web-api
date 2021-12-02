<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PositionExport implements FromView
{
    public function __construct($positions)
    {
        $this->positions = $positions;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.position', [
            'positions' => $this->positions
        ]);
    }
}
