<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkUnitExport implements FromView
{
    public function __construct($workUnits)
    {
        $this->workUnits = $workUnits;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.work-unit', [
            'workUnits' => $this->workUnits
        ]);
    }
}
