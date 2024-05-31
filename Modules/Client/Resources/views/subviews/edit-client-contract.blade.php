<div class="card">
    <div id="">

        @php
            $contractLevel = old('contract_level') ?? ($client->meta->first()->value ?? null);
            $checked = $contractLevel === 'client' ? 'checked' : '';
        @endphp

        <div class="form-check-inline mr-0 form-group mt-1 ml-2">
            <input type="checkbox" class="checkbox-custom mb-1.9 mb-1.67 mr-3" style="margin-top: 10px"
                id="contract_level_checkbox" name="contract_level" value="client"
                {{ $checked === 'checked' ? 'checked' : '' }}>

            <label class="form-check-label" for="contract_level_checkbox">Is this a client-level contract?
                <span data-toggle="tooltip" data-placement="right"
                    title="Check if this client's all project works as client level"><i
                        class="fa fa-question-circle"></i>&nbsp;</span>  @can('finance_reports.view')
                        <a class="badge badge-primary p-1 ml-2 text-light"
                            href="{{ route('report.project.contracts.index') }}">Contract Report</a>
                    @endcan</label>
        </div>

        <div class="card-body" id="contract_fields" style="{{ $checked ? '' : 'display: none' }}">
            <div class="row">
                <div class="col-4">
                    Upload Contract:
                </div>
                <div class="col-3">
                    Start Date:
                </div>
                <div class="col-3">
                    End date:
                </div>

            </div>
            <div class="row mt-3">
                <div class="col-4">
                    <div class="custom-file mb-3">
                        <input type="file" id="contract_file" name="contract_file" class="custom-file-input">
                        <label for="contract_file" class="custom-file-label overflow-hidden">Upload New
                            Contract</label>
                        <div class="indicator" style="margin-top: 3px">
                            @if ($client->clientContracts->isEmpty() == false)
                                <a id="contract_file mt-5" style="{{ $client->clientContracts ? '' : 'd-none' }}"
                                    href="{{ route('client.pdf.show', $client->clientContracts->first()) }}"
                                    target="_blank">
                                    <span class="mr-1 underline theme-info fz-16">File:
                                        {{ $client->name }}_Contract</span>
                                    <i class="fa fa-external-link-square fa-1x"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" name="start_date" id="start_date"
                        value="{{ $client->clientContracts->first()->start_date ?? '' }}">
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" name="end_date" id="end_date"
                        value="{{ $client->clientContracts->first()->end_date ?? '' }}">
                </div>

            </div>
        </div>
        <div class="m-5">
            <span class="mb-3" style="text-decoration: underline;" type="button" data-toggle="collapse"
                data-target="#contractHistory" aria-expanded="false" aria-controls="contractHistory">Contract
                History <i class="fa fa-history ml-1" aria-hidden="true"></i></span>
            <div class="collapse" id="contractHistory">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">File</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client->clientContracts as $contract)
                            <tr>
                                <td> <a href="{{ route('client.pdf.show', $client->clientContracts->first()) }}"
                                        target="_blank">{{ basename($contract->contract_file_path) }}</a></td>
                                <td>{{ optional($contract->start_date)->format('d M Y') ?? '-' }}</td>
                                <td>{{ optional($contract->end_date)->format('d M Y') ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            @include('client::subviews.edit-client-form-submit-buttons')
        </div>
    </div>
</div>

<script>
    document.getElementById('contract_level_checkbox').addEventListener('change', function() {
        var cardBody = document.getElementById('contract_fields');
        if (this.checked) {
            cardBody.style.display = '';
        } else {
            cardBody.style.display = 'none';
        }
    });
</script>
