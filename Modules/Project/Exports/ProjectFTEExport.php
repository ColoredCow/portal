<?php

namespace Modules\Project\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProjectFTEExport implements FromArray, WithHeadings, ShouldAutoSize, WithTitle
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
                'Team Member Project FTE'
            ];
    }

    public function title(): string
    {
        return 'FTE';
    }

}