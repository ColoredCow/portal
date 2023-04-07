@extends('hr::layouts.master')
@section('content')


<div class="container" id="segments_parameters_container">
    <br>
    <br>
    <div>
        <div class="d-flex justify-content-between">
            <h1 class="mb-0">{{ $segment->name }}</h1>
            <div>
                <button data-toggle="modal" data-target="#createNewParameterModal" class="btn btn-primary">Add New</button>
            </div>
        </div>

        <br>

        <table class="table table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Marks</th>
                <th>Action</th>
            </tr>
            @foreach ($parentParameters as $parentParameter)
            @include('hr::evaluation.parameters.render-parameter', ['depth' => 1, 'parameter' => $parentParameter])
            @endforeach
        </table>
    </div>
    @include('hr::evaluation.parameters.create')
    @include('hr::evaluation.parameters.edit')
    @include('hr::evaluation.parameters.assign-parent')
</div>


@endsection

@section('js_scripts')
<script>
    new Vue({
    el:'#segments_parameters_container',

    data() {
        return {
            updateRoute: "{{ route('hr.evaluation.parameter.update', [$segment->id, 'PARAMETER_ID']) }}",
            updateParentRoute: "{{ route('hr.evaluation.parameter.update-parent', [$segment->id, 'PARAMETER_ID']) }}",
            parameterOptions: [],
            selectedParameter: {},
            updateParameterOptions: [],
            selectedParentParameter: '',
            selectedParentParameterOption: '',
            selectedParentParameterOptions: []
        }
    },

    methods: {
        editParameter(parameter) {
            this.updateRoute = this.updateRoute.replace('PARAMETER_ID', parameter.id);
            this.selectedParameter = parameter;
            this.updateParameterOptions = parameter.options ? parameter.options : [];
            $('#updateParameterModal').modal('show');
        },

        assignParentParameter(parameter) {
            this.updateParentRoute = this.updateParentRoute.replace('PARAMETER_ID', parameter.id);
            this.selectedParameter = parameter;
            this.selectedParentParameter = parameter.parent ? parameter.parent.id : '';
            this.selectedParentParameterOption = parameter.parent_option_id ? parameter.parent_option_id : '';
            this.selectedParentParameterOptions = parameter.parent ? parameter.parent.options : [];
            $('#assignParentParameterModal').modal('show');
        },

        onSelectParentParameter(event) {
            let dataSet = event.target.options[event.target.options.selectedIndex].dataset;

            if(!dataSet.parameter) {
                this.selectedParentParameterOptions = [];
                this.selectedParentParameterOption = '';
                return true;
            }

            let parameter = JSON.parse(dataSet.parameter)
            this.selectedParentParameterOptions = parameter.options
        },

        newParameterOption() {
            return {
                    id: new Date().getTime(),
                    label:'',
                    marks: '',
                    new: true
                }
        },
        
        addNewParameterOption() {
            this.parameterOptions.push(this.newParameterOption());
        },

        addUpdateParameterOption() {
            this.updateParameterOptions.push(this.newParameterOption());
        },
        
        removeParameterOption(index) {
            this.parameterOptions.splice(index, 1);
        },

        removeUpdateParameterOption(index) {
            this.updateParameterOptions.splice(index, 1);
        }
    },

    mounted() {
        this.addNewParameterOption();
    }
});

</script>

@endsection