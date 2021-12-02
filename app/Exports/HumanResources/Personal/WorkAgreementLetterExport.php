<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WorkAgreementLetterExport implements FromView
{
    public function __construct($workAgreementLetters)
    {
        $this->workAgreementLetters = $workAgreementLetters;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.work-agreement-letter', [
            'workAgreementLetters' => $this->workAgreementLetters
        ]);
    }
}
