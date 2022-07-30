@extends('invoice::layouts.master')
@section('content')
    <div class="mx-4" id="ledgerAccountsSection">
        <div class="mt-4 card" >
            <div class="card-header">
                <h1>{{ __('Ledger Accounts') }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('ledger-accounts.index') }}" method="GET">
                    <div class='d-flex'>
                        <div class='w-30p'>
                            <div>
                                <label for="clientId" class="field-required">{{ __('Client') }}</label>
                            </div>
                            <div>
                                <select name="client_id" id="clientId" class="form-control" @change="submitForm($event)" required="required"
                                    @change="updateClientDetails()" v-model="clientId">
                                    <option value="">Select Client</option>
                                    <option v-for="client in clients" :value="client.id" v-text="client.name" :key="client.id"></option>
                                </select>
                            </div>
                        </div>
                        <div class='w-30p ml-2'>
                            <div>
                                <label for="projects" class="field-required">
                                    {{ __('Project') }}
                                </label>
                            </div>
                            <div>
                                <select name="project_id" id="projects" class="form-control" @change="submitForm($event)" v-model="projectId">
                                    <option value="">Select Project</option>
                                    <option v-for="project in projects" :value="project.id" v-text="project.name" :key="project.id">
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="border">
                <div class="w-100p mt-3">
                    <h3 class="font-weight-bold">{{ __('Details') }}</h3>
                    <form id="ledgerForm" action="{{ route('ledger-accounts.store') }}" method="POST">
                        @csrf
                        <table class="table-bordered w-100p">
                            <thead class="table-dark">
                                <th class="py-2 px-1">{{ __('Date') }}</th>
                                <th class="py-2 px-1">{{ __('Particulars') }}</th>
                                <th class="py-2 px-1">{{ __('Credit') }}</th>
                                <th class="py-2 px-1">{{ __('Debit') }}</th>
                                <th class="py-2 px-1">{{ __('Balance') }}</th>
                                <th></th>
                            </thead>
                            <tbody v-for="(ledgerAccountRow, index) in ledgerAccountData">
                                <tr>
                                    <td>
                                        <input type="hidden" :name="`ledger_account_data[${index}][client_id]`" value="{{ $client->id }}">
                                        <input type="hidden" :name="`ledger_account_data[${index}][project_id]`" value="{{ optional($project)->id }}">
                                        <input class="py-2 w-full" type="hidden" :name="`ledger_account_data[${index}][id]`" v-model="ledgerAccountRow.id">
                                        <input class="py-2 w-full" :name="`ledger_account_data[${index}][date]`" v-model="ledgerAccountRow.date" type="date" required>
                                    </td>
                                    <td><input class="py-2 w-full" :name="`ledger_account_data[${index}][particulars]`" v-model="ledgerAccountRow.particulars" type="text"></td>
                                    <td><input class="py-2 w-full" :name="`ledger_account_data[${index}][credit]`" v-model="ledgerAccountRow.credit" type="number" step="0.01"></td>
                                    <td><input class="py-2 w-full" :name="`ledger_account_data[${index}][debit]`" v-model="ledgerAccountRow.debit" type="number" step="0.01"></td>
                                    <td><input class="py-2 w-full" :name="`ledger_account_data[${index}][balance]`" v-model="ledgerAccountRow.balance" type="number" step="0.01"></td>
                                    <td><div v-on:click="removeRow(index)" class="text-danger font-weight-bold fz-24 c-pointer px-1">&times;</div></td>
                                </tr>
                            </tbody>
                            <tr id="noDataSection" class="{{ count($ledgerAccountData) ? 'd-none' : '' }}">
                                <td colspan="6" class="p-3 text-center"> {{ __('No Data Available') }}</td>
                            </tr>
                        </table>
                    </form>
                    <div class="mt-2 ml-2 ">
                        <a v-on:click="addNewRow()" href="javascript: void(0);" class="c-pointer text-decoration-none text-dark border-bottom border-dark">{{ __('Add new row') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="btn btn-success" v-on:click="submitLedgerForm($event)"> {{ __('Save') }}</div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#ledgerAccountsSection',

            data() {
                return {
                    clients: @json($clients),
                    clientId: "{{ old('client_id', optional($client)->id) }}",
                    projectId: "{{ old('project_id', optional($project)->id) }}",
                    projects: @json($client->projects),
                    client: null,
                    ledgerAccountData: @json($ledgerAccountData),
                    disabled: false
                }
            },

            methods: {
                updateClientDetails: function () {
                    this.projects = {};
                    this.client = null;
                    for (var i in this.clients) {
                        let client = this.clients[i];
                        if (client.id == this.clientId) {
                            this.client = client;
                            this.projects = _.orderBy(client.projects, 'name', 'asc');
                        }
                    }
                },

                submitForm: function ($event) {
                    $event.target.form.submit();
                },

                submitLedgerForm: function($event) {
                    if (this.disabled) {
                        return
                    }
                    this.disabled = true;
                    $event.target.setAttribute('disabled', true);
                    $event.target.classList.add("disabled");
                    $('#ledgerForm').submit();
                    $event.target.attr('disabled', false);
                    $event.target.classList.remove("disabled");
                    this.disabled = false
                },

                defaultRow() {
                    return {
                        id: null,
                    }
                },

                addNewRow() {
                    $('#noDataSection').remove();
                    this.ledgerAccountData.push(this.defaultRow());
                },

                removeRow(index) {
                    alert('Functionality yet to be developed.')
                    return;
                    
                    this.ledgerAccountData.splice(index, 1);
                },
            },
        });
    </script>
@endsection
