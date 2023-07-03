<?php

namespace Modules\ClientAnalytics\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;
use Modules\ClientAnalytics\Services\ClientAnalyticsService;

use Modules\ClientAnalytics\Contracts\ClientAnalyticsServicesContract;




class ClientAnalyticsController extends Controller
{
    protected $analyticsService;

    public function __construct(ClientAnalyticsServicesContract $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $clients = Client::all();
    
        return view('clientanalytics::index', compact('clients'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('clientanalytics::create');
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
        return view('clientanalytics::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('clientanalytics::edit');
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
