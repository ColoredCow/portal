<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Services\User\UserReportService;
use Modules\User\Entities\User;
use Carbon\Carbon;

class UserReportController extends Controller
{
    protected $service;
    protected $userReportService;

    public function __construct(UserReportService $userReportService)
    {
        $this->userReportService = $userReportService;
    }

    public function getFteData(Request $request, User $user)
    {
        $type = $request->type;
        $startMonth = today()->subMonth(17)->format('Y-m');
        $endMonth = today()->format('Y-m');
        $months = [];
  
        $currentMonth = Carbon::createFromFormat('Y-m', $startMonth);
        
        while ($currentMonth->format('Y-m') <= $endMonth) {
            $months[] = $currentMonth->format('Y-m');
            $currentMonth->addMonth();
        }

        $reportFteData = $this->userReportService->getFteData($type, $user);

        return [
            'data' => $reportFteData,
            'labels' => $months,
        ];
    }
}
