<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Infrastructure\Services\InfrastructureService;

class InfrastructureController extends Controller
{
    protected $sdk;
    protected $service;

    public function __construct(InfrastructureService $service)
    {
        $this->service = $service;
        $this->sdk = new Sdk(['version' => 'latest', 'region' => 'ap-south-1']);
    }

    public function index()
    {
        $storageBuckets = $this->service->getStorageBuckets();
        return view('infrastructure::index')->with('storageBuckets', $storageBuckets);
    }

    public function getInstances()
    {
        $instances = $this->service->getServersInstances();
        return view('infrastructure::instances')->with('instances', $instances);
    }

    public function getBillingDetails()
    {
        return $this->service->getBillingDetails();
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('infrastructure::create');
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
        return view('infrastructure::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('infrastructure::edit');
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
