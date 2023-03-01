<br>
<table class="table">
    <thead class="thead-dark">
        <tr align="left">
            <th style="width: 440px;">Description</th>
            <th style="width: 135px;">
             @if($project->serviceRateTermFromProject_Billing_DetailsTable() == 'per_hour')
             Hours
             @else
             Months
             @endif
            </th>
            <th style="width: 135px;">Rate({{$client->country->initials . ' ' . config('constants.currency.' . $project->client->currency . '.symbol')}})</th>
            <th>Cost({{$client->country->initials . ' ' . config('constants.currency.' . $project->client->currency . '.symbol')}})</th>
        </tr>
    </thead>
    <thead class="thead-white">
        <tr align="left">
            <th style="width: 440px;">
               @if($project->is_amc == 1)
               {{ 'AMC Charges' }}
               @endif
            </th>
            <th style="width: 135px;">
            @if($project->serviceRateTermFromProject_Billing_DetailsTable() == 'per_month')
                {{$project->getmonthStatDateAndEndDateInPdf()['startDate'] ."-". $project->getmonthStatDateAndEndDateInPdf()['endDate'] }}
            @endif
            </th>
            <th style="width: 135px;"></th>
            <th align="center">
                @if($billingLevel == 'client') 
                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                        {{ '' }}
                    @else
                        {{ $client->getBillableAmountForTerm($monthsToSubtract, $projects, $periodStartDate, $periodEndDate) + optional($client->billingDetails)->bank_charges }}
                    @endif
                @else 
                    @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                        {{ $project->getResourceBillableAmount() }}
                    @else
                        @if($project->is_amc == 1)
                        {{ config('constants.currency.' . $project->client->currency . '.symbol') . $project->totalAmountWithOutTaxInPdf() }}
                        @else 
                        {{ $project->getBillableAmountForTerm($monthsToSubtract, $periodStartDate, $periodEndDate) + optional($project->client->billingDetails)->bank_charges }}
                        @endif
                    @endif     
                @endif
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projects as $project)
            @if($project->getBillableHoursForMonth($monthsToSubtract, $periodStartDate, $periodEndDate) == 0)
                @continue
            @endif
            <tr class="border-bottom">
                <td>{{$project->name}}</td>
                <td>{{$project->getBillableHoursForMonth($monthsToSubtract, $periodStartDate, $periodEndDate)}}</td>
                <td>{{optional($client->billingDetails)->service_rates}}</td>
                <td>{{round($project->getBillableHoursForMonth($monthsToSubtract, $periodStartDate, $periodEndDate) * $client->billingDetails->service_rates, 2)}}</td>
            </tr>
        @endforeach
        @if (optional($client->billingDetails)->bank_charges) 
            <tr class="border-bottom">
                <td colspan=3>{{__('Bank Charges')}}</td>
                <td>{{$client->billingDetails->bank_charges}}</td>
            </tr>
        @endif
    </tbody>
</table>