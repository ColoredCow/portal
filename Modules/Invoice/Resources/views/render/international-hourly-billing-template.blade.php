<br>
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th>Description</th>
            <th>Hours</th>
            <th>Rate({{$client->country->initials . ' ' . $client->country->currency_symbol}})</th>
            <th>Cost({{$client->country->initials . ' ' . $client->country->currency_symbol}})</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            @if($project->getBillableHourForTerm($monthNumber, $year) == 0)
                @continue
            @endif
            <tr>
                <td>{{$project->name}}</td>
                <td>{{$project->getBillableHourForTerm($monthNumber, $year)}}</td>
                <td>{{$currencyService->getCurrentRatesInINR()}}</td>
                <td>{{round($project->getBillableHourForTerm($monthNumber, $year) * $client->billingDetails->service_rates, 2)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>