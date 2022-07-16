<?php

namespace Modules\Report\Services\Finance;


class ExpenseReportService
{
    public function getAllParticulars($year)
    {
        $particulars =  config('report.finance.profit_and_loss.particulars.expenses');
        $results = [];
        foreach ($particulars as $particular) {
            $results[] = $this->getParticularReport($particular, $year);
        }
        return $results;
    }


    public function getParticularReport($particular, $year)
    {
        $results = [];
        $results['name'] = $particular['name'];
        $results['head'] = $particular['head'];
        $results['amount'] = $this->getParticularAmount($particular, $year);
        return $results;
    }

    private function getParticularAmount($particular, $year)
    {
        $amount = 0;
        return $amount;
    }
}
