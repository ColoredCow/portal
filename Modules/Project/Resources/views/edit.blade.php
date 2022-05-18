@extends('project::layouts.master')
@section('content')
    <div class="container" id="view_edit_project">
        <br>
        <a href="{{ URL::previous() }}"
            class="text-theme-body text-decoration-none mb-2 mb-xl-4 d-inline-flex align-items-center">
            <span class="mr-1 w-8 h-15 w-xl-12 h-xl-12">
                {!! file_get_contents(public_path('icons/prev-icon.svg')) !!}
            </span><span class="mr-3 w-26 h-15 w-xl-10 h-xl-10">Back</span>
        </a>
        <br>
        <h4 class="c-pointer d-inline-block" v-on:click="counter += 1">{{ $project->name }}</h4>
        <a target="_self" class="badge badge-primary p-1 ml-2 text-light pl-3 pr-3 " target="blank"
            href="{{ route('project.effort-tracking', $project) }}">{{ _('FTE') }}</a>
        <br>
        <div class="mt-2">
            <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="pill" data-bs-target="#project-details" type="button"
                        role="tab" aria-selected="true">Project details</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="pill" data-bs-target="#project-team-members" type="button"
                        role="tab" aria-selected="false">Project team members</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="pill" data-bs-target="#project-repository" type="button"
                        role="tab" aria-selected="false">Project repositories</a>
                </li>
            </ul>
            @include('status', ['errors' => $errors->all()])
            <div class="tab-content">
                <div class="tab-pane fade show active mb-5" id="project-details" role="tabpanel">
                    @include('project::subviews.edit-project-details')
                </div>

                <div class="tab-pane fade mb-5" id="project-team-members" role="tabpanel">
                    @include('project::subviews.edit-project-team-members')
                </div>

                <div class="tab-pane fade mb-5" id="project-repository" role="tabpanel">
                    @include('project::subviews.edit-project-repository')
                </div>
            </div>
        </div>
        @include('project::subviews.modal-success')
    </div>
@endsection


@section('js_scripts')
    <script>
        new Vue({
            el: '#view_edit_project',

            data() {
                return {
                    project: @json($project),
                    projectTeamMembers: @json($projectTeamMembers),
                    projectRepositories: @json($projectRepositories),
                    users: @json($teamMembers->sortBy('name')->values()),
                    designations: @json($designations)
                }
            },

            methods: {
                showAlert() {},

                defaultProjectTeamMember() {
                    return {
                        id: new Date().getTime(),
                        pivot: {

                        }
                    }
                },
                defaultProjectRepository() {
                    return {
                        id: new Date().getTime(),
                    }
                },

                updateProjectForm: async function(formId) {
                    $('.save-btn').attr('disabled', true);
                    let formData = new FormData(document.getElementById(formId));
                    $('.save-btn').removeClass('btn-primary').addClass('btn-dark');
                    await axios.post('{{ route('project.update', $project) }}', formData)
                        .then((response) => {
                            $('#edit-project-errors').addClass('d-none')
                            let url = $('#effort_sheet_url').val()
                            if (url) {
                                $('#view_effort_sheet_badge').removeClass('d-none')
                                $('#view_effort_sheet_badge').attr('href', url)
                            } else {
                                $('#view_effort_sheet_badge').addClass('d-none')
                            }
                            $('.save-btn').removeClass('btn-dark').addClass('btn-primary');
                            $('.save-btn').attr('disabled', false);
							$('#project-details-update-message').addClass('d-block');
                            $('#modal-success').modal('show');
                        })
                        .catch((error) => {
                            $('#project-details-update-message').addClass('d-none')
                            let errors = error.response.data.errors;
                            $('#edit-project-error-list').empty()
                            for (error in errors) {
                                $('#edit-project-error-list').append("<li class='text-danger ml-2'>" +
                                    errors[error] + "</li>");
                            }
                            $('#edit-project-errors').removeClass('d-none')
                            $('#modal-success').modal('show');
                        })
                },

                addNewProjectTeamMember() {
                    this.projectTeamMembers.push(this.defaultProjectTeamMember());
                },
                addNewProjectRepository() {
                    this.projectRepositories.push(this.defaultProjectRepository());
                },

                removeProjectTeamMember(index) {
                    this.projectTeamMembers.splice(index, 1);
                },
                removeProjectRepository(index) {
                    this.projectRepositories.splice(index, 1);
                },
            },

            mounted() {},
        });
    </script>
@endsection
