<?php

namespace App\Exports\HumanResources\Personal\Employee;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ChildExport implements FromView
{
    public function __construct($childs)
    {
        $this->childs = $childs;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.employee.child', [
            'childs' => $this->childs
        ]);
    }
}
