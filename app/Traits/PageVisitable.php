<?php

namespace App\Traits;

use App\Models\PageVisit;

trait PageVisitable
{
    public function recordPageVisit($userId, $pagePath)
    {
        $today = now()->today();

        $visit = PageVisit::where('user_id', $userId)->where('page_path', $pagePath)->whereDate('created_at', $today)->first();

        if (! $visit) {
            $visit = new PageVisit;
            $visit->user_id = $userId;
            $visit->page_path = $pagePath;
        }

        $visit->visit_count++;
        $visit->save();
    }

    public function getPageVisits($pagePath, $interval = 'daily')
    {
        $visits = PageVisit::where('page_path', $pagePath);
        $this->applyTimeIntervalFilter($visits, $interval);

        return $visits->orderByDesc('visit_count')->get();
    }

    protected function applyTimeIntervalFilter($query, $interval)
    {
        $today = now()->today();

        switch ($interval) {
            case 'daily':
                $query->whereDate('created_at', $today);
                break;

            case 'weekly':
                $query->whereDate('created_at', '>=', $today->startOfWeek())
                    ->whereDate('created_at', '<=', $today->endOfWeek());
                break;

            case 'monthly':
                $query->whereMonth('created_at', $today->month);
                break;
        }
    }
}
