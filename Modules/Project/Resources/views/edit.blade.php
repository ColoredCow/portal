@extends('project::layouts.master')
@section('content')

<div class="container" id="view_edit_project">
    <br> <h4 clss="c-pointer" v-on:click="counter += 1">{{ $project->name }} ({{ $project->client_project_id }})</h4>
    <br>
    
    <div>
        @include('status', ['errors' => $errors->all()])
        <div class="mb-5">
            @include('project::subviews.edit-project-details')
        </div>

        <div class="mb-5">
            @include('project::subviews.edit-project-resources')
        </div>

         <div class="mb-5">
            @include('project::subviews.edit-project-repository')
        </div>

    </div>
</div>

@endsection


@section('js_scripts')
<script>
new Vue({ 
    el: '#view_edit_project',

    data() {
        return {
            project: @json($project),
            projectResources:@json($projectResources),
            projectRepositories:@json($projectRepositories),
            allResources:@json($resources->sortBy('name')->values()),
            resourcesDesignations:@json($resourcesDesignations)
        }
    },

    methods: {
        showAlert() {
            alert("Hello Hii");
        },

        defaultProjectResource() {
            return {
                id: new Date().getTime(),
                pivot:{
                    
                }
            }
        },
        defaultProjectRepository() {
            return {
                id: new Date().getTime(),
            }
        },

        updateProjectForm: async function(formId) {
            let formData = new FormData(document.getElementById(formId));
            let response = await axios.post('{{ route('project.update', $project) }}', formData);
            alert('Project information updated successfully');
        },

        addNewProjectResource() {
            this.projectResources.push(this.defaultProjectResource());
        },
        addNewProjectRepository() {
            this.projectRepositories.push(this.defaultProjectRepository());
        },

        removeProjectResource(index) {
            this.projectResources.splice(index, 1);
        },
        removeProjectRepository(index) {
            this.projectRepositories.splice(index, 1);
        },
    }, 

    mounted() {
    },
});

</script>

@endsection

