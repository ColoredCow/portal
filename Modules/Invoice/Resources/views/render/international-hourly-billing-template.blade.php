<br>
<table class="table">
    <thead class="thead-dark">
        <tr align="left">
            <th style="width: 440px;">Description</th>
            <th style="width: 135px;">
             @if($project->service_rate_term == 'per_hour')
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
               <span style="font-weight: normal">AMC Charges</span>
               @endif
            </th>
            <th style="width: 135px;">
                <span style="font-weight: normal" >
                    @if($project->client->billingDetails->billing_frequency == 2)
                        {{$project->getTermStartAndEndDateForInvoice()['startDate']->format('M-Y')}}
                    @elseif($project->client->billingDetails->billing_frequency == 3)
                        @if ($project->service_rate_term == "per_month")
                        {{$project->getTermStartAndEndDateForInvoice()['startDate']->format('M-Y')}}
                        @else 
                        {{ $project->getTermStartAndEndDateForInvoice()['startDate']->format('M-Y')." ". $project->getTermStartAndEndDateForInvoice()['endDate']->format('M-Y') }}
                        @endif
                    @endif
                </span>
            </th>
            <th style="width: 135px;"></th>
            <th align="center"><span style="font-weight: normal">
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
                        {{ config('constants.currency.' . $project->client->currency . '.symbol') . $project->amcTotalProjectAmount() }}
                        @else 
                        {{ $project->getBillableAmountForTerm($monthsToSubtract, $periodStartDate, $periodEndDate) + optional($project->client->billingDetails)->bank_charges }}
                        @endif
                    @endif     
                @endif
                </span>
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