<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrganizationExport implements FromView
{
    public function __construct($organizationHistories)
    {
        $this->organizationHistories = $organizationHistories;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.organization-history', [
            'organizationHistories' => $this->organizationHistories
        ]);
    }
}
