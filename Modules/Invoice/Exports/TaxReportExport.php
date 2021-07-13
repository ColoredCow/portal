<?php

namespace Modules\Invoice\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TaxReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function collection()
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        if(is_array($this->invoices->first())) {
            return array_keys($this->invoices->first());
        }

        return [];
    }

    public function title(): string 
    {
        return "Monthly tax report";
    }
}
