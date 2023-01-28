<br>
<table class="table">
    <thead class="thead-dark">
        <tr align="left">
            <th style="width: 408px;">Description</th>
            <th style="width: 240px;">Monthly Engagement(%)</th>
            <th>Cost({{$client->country->initials . ' ' . $client->country->currency_symbol}})</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($project->getTeamMembersGroupedByEngagement() as $resourceGroup)
            <tr class="border-bottom">
                <td>{{$resourceGroup->resource_count . __(' Resources')}}</td>
                <td>{{$resourceGroup->billing_engagement}}</td>
                <td>{{round($resourceGroup->resource_count * $client->billingDetails->service_rates * ($resourceGroup->billing_engagement/100), 2)}}</td>
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