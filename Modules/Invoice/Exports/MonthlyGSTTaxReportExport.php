<?php

namespace Modules\Invoice\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MonthlyGSTTaxReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->invoices;
    }

    public function headings(): array
    {
        if (is_array($this->invoices->first())) {
            return array_keys($this->invoices->first());
        }

        return [];
    }

    public function title(): string
    {
        return 'Monthly GST Tax Report';
    }
}
