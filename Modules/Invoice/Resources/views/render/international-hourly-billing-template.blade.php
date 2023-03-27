<br>
<table class="table">
    <thead class="thead-dark">
        <tr align="left">
            <th style="width: 440px;">Description</th>
            <th style="width: 140px;">
             @if(optional($project)->service_rate_term == 'per_hour')
             Hours
             @else
             Months
             @endif
            </th>
            <th style="width: 145px;">Rate
                @if($client && $project)
                    @if($client->country)
                    {{$client->country->initials . ' ' . config('constants.currency.' . $project->client->currency . '.symbol')}}
                    @endif
                @endif
            </th>
            <th>Cost
                @if($client && $project)
                    @if($client->country)
                    {{$client->country->initials . ' ' . config('constants.currency.' . $project->client->currency . '.symbol')}}
                    @endif
                @endif
            </th>
        </tr>
    </thead>
    @if($project)
        @if($project->is_amc == 1) 
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
                                    <?php
                                    $termStartEndDate = $client->getTermStartAndEndDateForInvoice();
                                    $termStartDate = $termStartEndDate['startDate'];
                                    $termEndDate = $termStartEndDate['endDate'];
                                    ?>
                                    {{ $client->$client->amountWithoutTaxForTerm($termStartDate, $termEndDate) + optional($client->billingDetails)->bank_charges }}
                                @endif
                            @else 
                                @if(optional($client->billingDetails)->service_rate_term == config('client.service-rate-terms.per_resource.slug'))
                                    {{ $project->getResourceBillableAmount() }}
                                @else
                                    @if($project->is_amc == 1)
                                        <?php
                                        $termStartEndDate = $project->getTermStartAndEndDateForInvoice();
                                        $termStartDate = $termStartEndDate['startDate'];
                                        $termEndDate = $termStartEndDate['endDate'];
                                        ?>
                                    {{ config('constants.currency.' . $project->client->currency . '.symbol') . $project->amountWithTaxForTerm($termStartDate, $termEndDate) }}
                                    @else 
                                    <?php 
                                    $termStartDate = $project->client->getMonthStartDateAttribute($monthToSubtract = 1);
                                    $termEndDate = $project->client->getMonthEndDateAttribute($monthToSubtract = 1);
                                    ?>
                                    {{ $project->amountWithTaxForTerm($termStartDate, $termEndDate) }}
                                    @endif
                                @endif     
                            @endif
                            </span>
                        </th>
                    </tr>
                </thead>
            
        @endif  
    @endif
    <tbody>
        @foreach ($projects as $project)
            <?php
            $termStartEndDate = $project->getTermStartAndEndDateForInvoice();
            $termStartDate = $termStartEndDate['startDate'];
            $termEndDate = $termStartEndDate['endDate'];
            ?>

            @if($project->getBillableHoursForTerm($termStartDate, $termEndDate) == 0)
                @continue
            @endif
            <tr class="border-bottom">
                <td>{{$project->name}}</td>
                <td style="width: 150px;">
                    @if($project->getBillingLevel() == 'project')
                        @if($project->client->billingDetails->billing_frequency == 2)
                            {{$project->getTermStartAndEndDateForInvoice()['startDate']->format('M-Y')}}
                        @elseif($project->client->billingDetails->billing_frequency == 3)
                            @if ($project->service_rate_term == "per_month")
                            {{$project->getTermStartAndEndDateForInvoice()['startDate']->format('M-Y')}}
                            @else 
                            {{ $project->getTermStartAndEndDateForInvoice()['startDate']->format('M-Y')." ". $project->getTermStartAndEndDateForInvoice()['endDate']->format('M-Y') }}
                            @endif
                        @else
                            <?php 
                            $termStartDate = $project->client->getMonthStartDateAttribute($monthToSubtract = 1);
                            $termEndDate = $project->client->getMonthEndDateAttribute($monthToSubtract = 1);
                            ?>
                            @if($project->service_rate_term == 'per_month')
                                {{ $termStartDate->format('M-Y') }}
                            @else
                                {{ $termStartDate->format('M-Y')." ".$termEndDate->format('M-Y') }}
                            @endif
                        @endif
                    @else
                    {{$project->getBillableHoursForTerm($monthsToSubtract, $periodStartDate, $periodEndDate)}}</td>
                    @endif
                <td>{{$project->getServiceRateAttribute()}}</td>
                <td>
                    <?php 
                    $termStartDate = $project->client->getMonthStartDateAttribute($monthToSubtract = 1);
                    $termEndDate = $project->client->getMonthEndDateAttribute($monthToSubtract = 1);
                    ?>
                    {{ $project->amountWithoutTaxForTerm($termStartDate, $termEndDate) }}
                </td>
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