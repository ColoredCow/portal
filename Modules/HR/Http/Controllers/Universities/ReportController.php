<?php

namespace Modules\HR\Http\Controllers\Universities;

use Illuminate\Routing\Controller;
use Modules\HR\Entities\University;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('reports', University::class);

        return view('hr::universities.reports');
    }
}
