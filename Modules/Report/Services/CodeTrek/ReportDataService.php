<?php

namespace Modules\Report\Services\CodeTrek;
use Modules\CodeTrek\Entities\CodeTrekApplicant;

class ReportDataService
{
    public function getDataForDailyCodeTrekApplications($type, $filters)
    {
        if ($type == 'codetrek-application') {
            $applicants = CodeTrekApplicant::find('start_date');
            $defaultStartDate = $applicants->created_at ?? today()->subYear();
            $defaultEndDate = today();
            $filters['start_date'] = empty($filters['start_date']) ? $defaultStartDate : $filters['start_date'];
            $filters['end_date'] = empty($filters['end_date']) ? $defaultEndDate : $filters['end_date'];
            $applicantChartData = CodeTrekApplicant::select(\DB::Raw('DATE(start_date) as date, COUNT(*) as count'))
                ->whereDate('start_date', '>=', $filters['start_date'])
                ->whereDate('start_date', '<=', $filters['end_date'])
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
