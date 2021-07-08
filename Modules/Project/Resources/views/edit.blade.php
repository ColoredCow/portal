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

        <div>
            @include('project::subviews.edit-project-resources')
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
            allRsources:@json($resources),
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

        updateProjectForm: async function(formId) {
            let formData = new FormData(document.getElementById(formId));
            let response = await axios.post('{{ route('project.update', $project) }}', formData);
            alert('Project information updated successfully');
        },

        addNewProjectResource() {
            this.projectResources.push(this.defaultProjectResource());
        },

        removeProjectResource(index) {
            this.projectResources.splice(index, 1);
        }
    }, 

    mounted() {
    },
});

</script>

@endsection

