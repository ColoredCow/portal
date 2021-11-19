<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Infrastructure\Contracts\InfrastructureServiceContract;


class InfrastructureController extends Controller
{
    protected $sdk;
    protected $service;

    public function __construct(InfrastructureServiceContract $service)
    {
        $this->service = $service;
        $this->sdk = new Sdk(['version' => 'latest', 'region' => 'ap-south-1']);
    }

    public function index()
    {
        if(Auth::user()->can('infrastructure.backups.view'))
        {
            $storageBuckets = $this->service->getStorageBuckets();

            return view('infrastructure::index')->with('storageBuckets', $storageBuckets);
        }
        else
        {
            abort('403');
        }
        
    }

    public function getInstances()
    {
        if(Auth::user()->can('infrastructure.ec2-instances.view'))
        {
            $instances = $this->service->getServersInstances();

            return view('infrastructure::instances')->with('instances', $instances);
        }
        else
        {
            abort('403');
        }
        
    }

    public function getBillingDetails()
    {
        if(Auth::user()->can('infrastructure.billings.view'))
        {
            return $this->service->getBillingDetails();
        }
        else
        {
            abort('403');
        }
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
