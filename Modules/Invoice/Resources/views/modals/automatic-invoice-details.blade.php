<div class="modal fade" tabindex="-1" id="modal-invoice-details{{ $project->id }}" value="{{ $project->id }}">
    <div class="modal-dialog " role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $project->name }} Invoice Details</h4>
            </div>
            <div>
                <table>
                    <tr>
                        <th>&nbsp</th>
                        <th>Current term details</th>
                        <th>Previous term details</th>
                    </tr>
                    @foreach ($lastInvoices as $invoice)
                        @if ($invoice !== null && $invoice->client_id == $project->client_id)
                            <tr>
                                <td>Booked hours</td>
                                <td>{{ $project->getHoursBookedForMonth($monthToSubtract = 0) }} Hrs.</td>
                                <td> {{ $project->getHoursBookedForMonth($monthToSubtract = 1) }} Hrs.</td>
                            </tr>
                            @php
                                $diff = $invoice->total_amount - str_replace(['$', '₹'], '', $amount);
                            @endphp
                            <tr>
                                <td>Amount</td>
                                <td>{{ config('constants.currency.' . $project->client->currency . '.symbol') . '' . $invoice->client->current_hours_in_projects * $project->client->billingDetails->service_rates }}
                                </td>
                                <td>{{ $amount }}</td>
                            </tr>
                        @break
                    @endif
                @endforeach
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
