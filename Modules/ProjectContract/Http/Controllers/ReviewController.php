<?php

namespace Modules\ProjectContract\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Modules\ProjectContract\Services\ProjectContractService;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    protected $services;
    public function __construct(ProjectContractService $services)
    {
        $this->services = $services;
    }

    public function index($id, $email)
    {
        $contracts = $this->services->view_contract($id);
        $contractsmeta = $this->services->view_contractmeta($id);
        $reviewer = $this->services->view_reviewer($id, $email);
        return view('projectcontract::review-contract')->with('contracts', $contracts)->with('contractsmeta', $contractsmeta)->with('reviewer', $reviewer);
    }

    public static function review($id, $email)
    {
        return URL::SignedRoute(
            'review',
            ['user' => $id, 'email' => $email]
        );
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('projectcontract::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('projectcontract::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('projectcontract::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}