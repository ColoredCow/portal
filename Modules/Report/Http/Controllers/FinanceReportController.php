<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Routing\Controller;


class FinanceReportController extends Controller
{
    public function __construct()
    {
    }

    public function profitAndLoss()
    {
        return view('report::finance.profit-and-loss');
    }
}
