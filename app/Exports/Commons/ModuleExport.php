<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ModuleExport implements FromView
{
    public function __construct($modules)
    {
        $this->modules = $modules;
    }

    public function view(): View
    {
        return view('exports.commons.module', [
            'modules' => $this->modules
        ]);
    }
}
