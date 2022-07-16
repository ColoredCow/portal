<?php

namespace Modules\Report\Services\Finance;

class ProfitAndLossReportService
{
    public function profitAndLoss(array $filters): array
    {
        $transaction = $filters['transaction'];
        $year = $filters['year'];

        $startYear = $year - 1;
        $endYear = $year;

        if ($transaction == 'revenue') {
            return app(RevenueReportService::class)->getAllParticulars($startYear, $endYear);
        }

        return [];
    }
}
