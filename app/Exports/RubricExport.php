<?php

namespace App\Exports;

use App\Models\Rubrica;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RubricExport implements FromView, ShouldAutoSize, WithColumnWidths, WithStyles
{
    use Exportable;
    
    public $id_rubrica;
    public function __construct($id_rubrica)
    {
        $this->id_rubrica = $id_rubrica;
    }


    public function view(): View
    {
        return view('export.rubricaEXCEL', [
            'rubrica' => Rubrica::find($this->id_rubrica)
        ]);
    }
    public function columnWidths(): array
    {
        return [
            'B' => 85,
            'C' => 85,
            'D' => 85,
            'E' => 85,
            'F' => 85,
            'G' => 85,
            'H' => 85,
                   
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B2:B300')->getAlignment()->setWrapText(true);
        $sheet->getStyle('C2:C300')->getAlignment()->setWrapText(true);
        $sheet->getStyle('D2:D300')->getAlignment()->setWrapText(true);
        $sheet->getStyle('E2:E300')->getAlignment()->setWrapText(true);
        $sheet->getStyle('F2:F300')->getAlignment()->setWrapText(true);
        $sheet->getStyle('G2:G300')->getAlignment()->setWrapText(true);
        $sheet->getStyle('H2:H300')->getAlignment()->setWrapText(true);
        /* $sheet->getStyle('C2:W25')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
 ]); */
        $sheet->getStyle('A1')->getFont()->setSize(15);
    }
}
