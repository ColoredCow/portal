<?php

namespace Modules\Infrastructure\Http\Controllers;

use Aws\Sdk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

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
        // return Cache::remember('aws_ec2_Client', $seconds, function () {
        //     return $this->getAWSBillingDetails();
        // });

        $ec2Client = $this->sdk->createEc2();
        $instances = $ec2Client->DescribeInstances()->toArray()['Reservations'];
        return view('infrastructure::ec2_instances')->with('instances', $instances);
    }

    public function getBillingDetails()
    {
        $seconds = 1800;
        return Cache::remember('aws_billing_data', $seconds, function () {
            return $this->getAWSBillingDetails();
        });
    }

    public function getAWSBillingDetails()
    {
        $costExplorerClient = $this->sdk->createCostExplorer();
        $currentDate = Carbon::now();
        $lastYear = (clone $currentDate)->subYear(1);
        $last12MonthCost = $costExplorerClient->getCostAndUsage(['Metrics' => ['AMORTIZED_COST'], 'Granularity' => 'MONTHLY', 'TimePeriod' => ['Start' => $lastYear->format('Y-m-d'), 'End' => $currentDate->format('Y-m-d')]])->toArray();
        $results = $this->formatCostByMonth($last12MonthCost['ResultsByTime']);
        $lastMonthCostData = $results[(clone $currentDate)->subMonth(1)->format('Y-m')];
        $lastMonthAmount = $lastMonthCostData['To_Display'];

        $currentCostData = $results[$currentDate->format('Y-m')];
        $currentAmount = $currentCostData['To_Display'];

        $monthlyForCast = $costExplorerClient->getCostForecast([
            'Metric' => 'AMORTIZED_COST',
            'Granularity' => 'MONTHLY',
            'TimePeriod' => [
                'Start' => (clone $currentDate)->addDay(1)->format('Y-m-d'),
                'End' => (clone $currentDate)->addDay(2)->format('Y-m-d')]])
            ->toArray();

        $currentMonthForCastData = $monthlyForCast['Total'];
        $forCastAmount = round($currentMonthForCastData['Amount'], 2) . ' ' . $currentMonthForCastData['Unit'];

        $lastYearAvg = (collect($results)->sum('Amount') - $currentCostData['Amount']) / 12;

        return [
            'current_amount' => $currentAmount,
            'last_month_amount' => $lastMonthAmount,
            'forcast_amount' => $forCastAmount,
            'should_alert' => round($currentMonthForCastData['Amount'], 2) > round($lastMonthCostData['Amount'], 2),
            'avg_by_last_year' => round($lastYearAvg, 2) . ' ' . $currentMonthForCastData['Unit']
        ];
    }

    public function formatCostByMonth($monthlyBillingCostData)
    {
        $results = [];
        foreach ($monthlyBillingCostData as $data) {
            $date = $data['TimePeriod']['Start'];
            $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
            $formattedData = $data['Total']['AmortizedCost'];
            $formattedData['Amount'] = round($formattedData['Amount'], 2);
            $formattedData['To_Display'] = $formattedData['Amount'] . ' ' . $formattedData['Unit'];
            $results[$carbonDate->format('Y-m')] = $formattedData;
        }

        return $results;
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
