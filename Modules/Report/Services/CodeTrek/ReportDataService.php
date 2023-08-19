<?php

namespace Modules\Report\Services\CodeTrek;

use Modules\CodeTrek\Entities\CodeTrekApplicant;

class ReportDataService
{
    public function getDataForDailyCodeTrekApplications($type, $filters)
    {
        if ($type == 'codetrek-application') {
            $filterStartDate = empty($filters['start_date']) ? today()->subYear() : $filters['start_date'];
            $filterEndDate = empty($filters['end_date']) ? today() : $filters['end_date'];
            $applicantChartData = CodeTrekApplicant::select(\DB::Raw('DATE(start_date) as date, COUNT(*) as count'))
                ->whereDate('start_date', '>=', $filterStartDate)
                ->whereDate('start_date', '<=', $filterEndDate)
                ->groupBy('date');

            $dates = $applicantChartData->pluck('date')->toArray();
            $counts = $applicantChartData->pluck('count')->toArray();
            $chartData = [
                'dates' => $dates,
                'counts' => $counts,
            ];

            $reportApplicantData = json_encode($chartData);

            return $reportApplicantData;
        }
    }
}
