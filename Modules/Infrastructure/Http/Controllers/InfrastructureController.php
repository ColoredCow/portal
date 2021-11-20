<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Illuminate\Routing\Controller;
use Modules\Infrastructure\Contracts\InfrastructureServiceContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use app\policies\Infrastruture\BillingsPolicy;

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
        $this->authorize('Backupview');
        $storageBuckets = $this->service->getStorageBuckets();
        return view('infrastructure::index')->with('storageBuckets', $storageBuckets);
    }

    public function getInstances()
    {
        $this->authorize('Billingview');
        $instances = $this->service->getServersInstances();
        return view('infrastructure::instances')->with('instances', $instances);

    }

    public function getBillingDetails()
    {
        $this->authorize('Ec2Instancesview');
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
