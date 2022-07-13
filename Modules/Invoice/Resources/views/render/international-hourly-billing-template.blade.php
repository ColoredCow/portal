<br>
<table class="table">
    <thead class="thead-dark">
        <tr align="left">
            <th style="width: 408px;">Description</th>
            <th style="width: 95px;">Hours</th>
            <th style="width: 135px;">Rate({{$client->country->initials . ' ' . $client->country->currency_symbol}})</th>
            <th>Cost({{$client->country->initials . ' ' . $client->country->currency_symbol}})</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            @if($project->getBillableHoursForTerm($monthNumber, $year) == 0)
                @continue
            @endif
            <tr class="border-bottom">
                <td>{{$project->name}}</td>
                <td>{{$project->getBillableHoursForTerm($monthNumber, $year)}}</td>
                <td>{{optional($client->billingDetails)->service_rates}}</td>
                <td>{{round($project->getBillableHoursForTerm($monthNumber, $year) * $client->billingDetails->service_rates, 2)}}</td>
            </tr>
        @endforeach
    </tbody>
</table>