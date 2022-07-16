<?php

namespace Modules\Report\Services\Finance;


class ExpenseReportService
{
    public function getAllParticulars(String $year): array
    {
        $particulars =  config('report.finance.profit_and_loss.particulars.expenses');
        $results = [];
        foreach ($particulars as $particular) {
            $results[] = $this->getParticularReport($particular, $year);
        }
        return $results;
    }


    public function getParticularReport(array $particular, String $year): array
    {
        $results = [];
        $results['name'] = $particular['name'];
        $results['head'] = $particular['head'];

        // ToDO:: we need to add function to get the amount for each particular
        return $results;
    }
}
