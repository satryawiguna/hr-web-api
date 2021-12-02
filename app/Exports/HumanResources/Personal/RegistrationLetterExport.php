<?php

namespace App\Exports\HumanResources\Personal;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegistrationLetterExport implements FromView
{
    public function __construct($registrationLetters)
    {
        $this->registrationLetters = $registrationLetters;
    }

    public function view(): View
    {
        return view('exports.human-resources.personal.registration-letter', [
            'registrationLetters' => $this->registrationLetters
        ]);
    }
}
