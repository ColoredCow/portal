<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Illuminate\Routing\Controller;
use Modules\Infrastructure\Contracts\InfrastructureServiceContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InfrastructureController extends Controller
{
    protected $sdk;
    protected $service;
    use AuthorizesRequests;

    public function __construct(InfrastructureServiceContract $service)
    {
        $this->service = $service;
        $this->sdk = new Sdk(['version' => 'latest', 'region' => 'ap-south-1']);
    }

    public function index()
    {
        $this->authorize('Backupview', $this);
        $storageBuckets = $this->service->getStorageBuckets();
        return view('infrastructure::index')->with('storageBuckets', $storageBuckets);
    }

    public function getInstances()
    {
        $this->authorize('Ec2Instancesview', $this);
        $instances = $this->service->getServersInstances();
        return view('infrastructure::instances')->with('instances', $instances);
    }

    public function getBillingDetails()
    {
        $this->authorize('Billingview', $this);

        return $this->service->getBillingDetails();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
    }
}
