<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Modules\Infrastructure\Contracts\InfrastructureServiceContract;

class InfrastructureController extends Controller
{
    use AuthorizesRequests;
    protected $sdk;
    protected $service;

    public function __construct(InfrastructureServiceContract $service)
    {
        $this->service = $service;
        $this->sdk = new Sdk(['version' => 'latest', 'region' => 'ap-south-1']);
    }

    public function getS3Buckets()
    {
        $this->authorize('Backupview', $this);
        $storageBuckets = $this->service->getStorageBuckets();

        return view('infrastructure::s3-buckets')->with('storageBuckets', $storageBuckets);
    }

    public function getInstances()
    {
        $this->authorize('Ec2Instancesview', $this);
        $instances = $this->service->getServersInstances();

        return view('infrastructure::ec2-instances')->with('instances', $instances);
    }

    public function getBillingDetails()
    {
        $this->authorize('Billingview', $this);

        return $this->service->getBillingDetails();
    }
}
