<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkAreaExport implements FromView
{
    public function __construct($workAreas)
    {
        $this->workAreas = $workAreas;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.work-area', [
            'workAreas' => $this->workAreas
        ]);
    }
}
