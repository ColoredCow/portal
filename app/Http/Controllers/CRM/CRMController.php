<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Services\CRMServices;

class CRMController extends Controller
{
    /**
     * Service for the controller.
     *
     * @var CRMServices
     */

    /**
     * UserController constructor.
     *
     * @param CRMServices $service
     */
    public function __construct(CRMServices $service)
    {
        $this->service = $service;
    }
    protected $service;

    public function index()
    {
        $data = $this->service->getListData();

        return view('crm.index', ['data' => $data]);
    }
}
