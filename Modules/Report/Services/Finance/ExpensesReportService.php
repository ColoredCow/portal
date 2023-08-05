<?php

namespace Modules\Report\Services\Finance;

class ExpenseReportService
{
    public function getAllParticulars(string $year): array
    {
        // Todo:: fill the information here.
        return [];
    }

    public function getParticularReport(array $particular, string $year): array
    {
        $results = [];
        $results['name'] = $particular['name'];
        $results['head'] = $particular['head'];

        // ToDO:: we need to add function to get the amount for each particular
        return $results;
    }
}
