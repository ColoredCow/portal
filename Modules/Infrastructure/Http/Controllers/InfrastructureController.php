<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InfrastructureController extends Controller
{
    protected $sdk;

    public function __construct()
    {
        $this->sdk = new Sdk(['version' => 'latest', 'region' => 'ap-south-1']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $s3Client = $this->sdk->createS3();
        $completeSynchronously = $s3Client->listBucketsAsync()->wait();
        $s3Data = $completeSynchronously->toArray();
        $s3buckets = $s3Data['Buckets'];
        return view('infrastructure::index')->with('s3buckets', $s3buckets);
    }

    public function getEc2Instances()
    {
        $ec2Client = $this->sdk->createEc2();
        $instances = $ec2Client->DescribeInstances()->toArray()['Reservations'];
        return view('infrastructure::ec2_instances')->with('instances', $instances);
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
