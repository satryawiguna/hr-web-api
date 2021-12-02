<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class OtherEquipmentExport implements FromView
{
    public function __construct($otherEquipments)
    {
        $this->otherEquipments = $otherEquipments;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.other-equipment', [
            'otherEquipments' => $this->otherEquipments
        ]);
    }
}
