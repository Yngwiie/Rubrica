<?php

namespace App\Exports;

use App\Models\Rubrica;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class RubricExport implements FromView
{
    use Exportable;
    
    public $id_rubrica;
    public function __construct($id_rubrica)
    {
        $this->id_rubrica = $id_rubrica;
    }


    public function view(): View
    {
        return view('export.rubricaPDF', [
            'rubrica' => Rubrica::find($this->id_rubrica)
        ]);
    }
}
