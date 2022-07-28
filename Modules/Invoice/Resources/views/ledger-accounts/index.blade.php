@extends('invoice::layouts.master')
@section('content')
    <div class="container">
        <div class="mt-4 card" id="ledger_accounts_form">
            <div class="card-header">
                <h1>Ledger Accounts</h1>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <label for="clientId" class="field-required">Client</label>
                </div>
                <select name="client_id" id="clientId" class="form-control" required="required"
                    @change="updateClientDetails()" v-model="clientId">
                    <option value="">Select Client</option>
                    <option v-for="client in clients" :value="client.id" v-text="client.name" :key="client.id">
                    </option>
                </select>
                <div class="d-flex justify-content-between">
                    <div>
                        <label for="projects" class="field-required">
                            Project
                        </label>
                    </div>
                </div>
                <select name="project_id" id="projects" class="form-control" required="required">
                    <option value="">Select Project</option>
                    <option v-for="project in projects" :value="project.id" v-text="project.name" :key="project.id">
                    </option>
                </select>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        new Vue({
            el: '#ledger_accounts_form',

            data() {
                return {
                    clients: @json($clients),
                    clientId: '',
                    projects: {},
                    client: null,
                }
            },

            methods: {
                updateClientDetails: function() {
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
            },
        });
    </script>
@endsection
