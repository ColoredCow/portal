<?php

namespace App\Services;

class TimesheetService
{
    public function __construct()
    {
    }

    public function getMonthDates()
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();
        $monthDates = [];
        while ($startDate->lte($endDate)) {
            $monthDates[] = ['label' => $startDate->format('d, D'), 'slug' => $startDate->format('d-D')];
            $startDate->addDay();
        }
        return $monthDates;
    }
}
