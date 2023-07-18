<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Modules\Report\Services\Finance\ReportDataService;

class CodeTrekController extends Controller
{
    protected $service;

    public function __construct(ReportDataService $service)
    {
        $this->service = $service;
    }

    public function getApplicantData(Request $request)
    {
        $type = $request->type;
        $filters = $request->filters;

        return $this->service->getDataForDailyCodeTrekApplications($type, json_decode($filters, true), $request);
    }
}
