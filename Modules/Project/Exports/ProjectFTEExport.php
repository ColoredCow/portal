<?php

namespace Modules\Project\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectFTEExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle, WithStyles
{
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function array(): array
    {
        return $this->employees;
    }

    public function headings(): array
    {
        return [
                'Team Member',
                'Overall FTE',
                'Project Name',
                'Team Member Project FTE',
                'Committed Hours',
                'Booked Hours',
            ];
    }

    public function title(): string
    {
        return 'FTE';
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
