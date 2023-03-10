<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Report\Services\User\UserReportService;
use Modules\User\Entities\User;

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

        return $this->userReportService->getFteData($type, $user);
    }
}
