<?php

namespace Modules\AppointmentSlots\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HR\Entities\MaximumSlots;
use Modules\AppointmentSlots;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\AppointmentSlots\Contracts\AppointmentSlotsServiceContract;

class MaximumSlotsController extends Controller
{
    protected $service;

    public function __construct(AppointmentSlotsServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userData = MaximumSlots::getUserData();
        
        return view('appointmentslots::index')->with("userData", $userData);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        //
    }
}
