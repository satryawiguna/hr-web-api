<?php

namespace App\Exports\HumanResources\MasterData;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompetenceExport implements FromView
{
    public function __construct($competences)
    {
        $this->competences = $competences;
    }

    public function view(): View
    {
        return view('exports.human-resources.master-data.competence', [
            'competences' => $this->competences
        ]);
    }
}
