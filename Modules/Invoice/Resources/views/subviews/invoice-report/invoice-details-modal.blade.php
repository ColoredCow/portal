<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h4 class="modal-title">{{ __('Invoice Effort Details') }}</h4>
                </div>
                <button type="button" class="close"   data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr class="text-center">
                            <th class="w-150">{{ __('Team Member') }}</th>
                            <th>{{ __('Start Date') }}</th>
                            <th>{{ __('End Date') }}</th>
                            <th>{{ __('Working Days') }}</th>
                            <th>{{ __('Billable Hours') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teamMembers as $teamMemberName => $teamMemberData)
                            <tr>
                                <td>{{ $teamMemberName }}</td>
                                <td>{{ $client->getMonthStartDateAttribute(1)->format(config('invoice.default-date-format')) }}</td>
                                <td>{{ $client->getMonthEndDateAttribute(1)->format(config('invoice.default-date-format')) }}</td>
                                <td>{{ $client->getWorkingDays($client->getMonthStartDateAttribute(1), $client->getMonthEndDateAttribute(1)) }}</td>
                                <td>{{ $teamMemberData['billableHours'] }}</td>
                            </tr>
                            @if($loop->last)
                                <tr>
                                    <td colspan="4">{{ __('Total Billable Hours: ') }}</td>
                                    <td>{{ $teamMembers->sum('billableHours') }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr class="text-center">
                                <td colspan="5">{{ __('No Efforts') }}</td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>