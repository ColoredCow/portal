<?php

namespace Modules\AppointmentSlots\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @return Response
     */
    public function index()
    {
        return view('appointmentslots::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('appointmentslots::create');
    }

    public function showAppointments(Request $request, $params)
    {
        return view('appointmentslots::select_appointments.index', $this->service->showAppointments($request->all(), $params));
    }

    public function appointmentSelected(Request $request)
    {
        return $this->service->appointmentSelected($request->all());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('appointmentslots::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('appointmentslots::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
