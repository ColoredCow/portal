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

    public function showAppointments($params)
    {
        $data = $this->service->showAppointments($params);

        if (! $data) {
            return view('appointmentslots::select_appointments.interview_schedule_error_message');
        }

        return view('appointmentslots::select_appointments.index', $data);
    }

    public function appointmentSelected(Request $request)
    {
        return $this->service->appointmentSelected($request->all());
    }
}
