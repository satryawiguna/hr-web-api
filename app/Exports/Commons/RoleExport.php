<?php

namespace App\Exports\Commons;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RoleExport implements FromView
{
    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    public function view(): View
    {
        return view('exports.commons.role', [
            'roles' => $this->roles
        ]);
    }
}
