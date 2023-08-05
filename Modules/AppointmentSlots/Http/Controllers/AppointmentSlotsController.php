<?php

namespace Modules\AppointmentSlots\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AppointmentSlots\Contracts\AppointmentSlotsServiceContract;

class AppointmentSlotsController extends Controller
{
    protected $service;

    public function __construct(AppointmentSlotsServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('appointmentslots::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function showAppointments(Request $request, $params)
    {
        $data = $this->service->showAppointments($request->all(), $params);

        if (! $data) {
            return view('appointmentslots::select_appointments.interview_schedule_error_message');
        }

        return view('appointmentslots::select_appointments.index', $data);
    }

    public function appointmentSelected(Request $request)
    {
        return $this->service->appointmentSelected($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        //
    }
}
