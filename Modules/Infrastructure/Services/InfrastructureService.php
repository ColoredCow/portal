<?php

namespace Modules\Infrastructure\Services;

use Aws\Sdk;
use Carbon\Carbon;
use Aws\Credentials\Credentials;
use Illuminate\Support\Facades\Cache;
use Modules\Infrastructure\Contracts\InfrastructureServiceContract;

class InfrastructureService implements InfrastructureServiceContract
{
    public function __construct()
    {
        $credentials = new Credentials(config('infrastructure.services.aws.key'), config('infrastructure.services.aws.secret'));
        $this->sdk = new Sdk(['version' => 'latest', 'region' => 'ap-south-1', 'credentials' => $credentials]);
    }

    public function getStorageBuckets()
    {
        $s3Client = $this->sdk->createS3();
        $completeSynchronously = $s3Client->listBucketsAsync()->wait();
        $s3Data = $completeSynchronously->toArray();
        $s3buckets = $s3Data['Buckets'];

        return $s3buckets;
    }

    public function getServersInstances()
    {
        $ec2Client = $this->sdk->createEc2();
        $instances = $ec2Client->DescribeInstances()->toArray()['Reservations'];

        return $instances;
    }

    public function getBillingDetails()
    {
        $seconds = 1 * 60 * 60 * 24;

        return Cache::remember('aws_billing_datas', $seconds, function () {
            return $this->getAWSBillingDetails();
        });
    }

    private function getAWSBillingDetails()
    {
        $costExplorerClient = $this->sdk->createCostExplorer();
        $currentDate = Carbon::now();
        $lastYear = (clone $currentDate)->subYear(1);
        $last12MonthCost = $costExplorerClient->getCostAndUsage(['Metrics' => ['AMORTIZED_COST'], 'Granularity' => 'MONTHLY', 'TimePeriod' => ['Start' => $lastYear->format('Y-m-d'), 'End' => $currentDate->format('Y-m-d')]])->toArray();
        $results = $this->formatCostByMonth($last12MonthCost['ResultsByTime']);
        $lastMonthCostData = $results[(clone $currentDate)->subMonth(1)->format('Y-m')];
        $lastMonthAmount = $lastMonthCostData['To_Display'];

        $currentCostData = $results[$currentDate->format('Y-m')] ?? $lastMonthCostData;
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

    private function formatCostByMonth($monthlyBillingCostData)
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
}
