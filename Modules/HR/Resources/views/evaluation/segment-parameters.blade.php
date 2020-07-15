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
            @foreach ($parameters as $parameter)
            <tr>
                <td class="w-70p">
                    <a href="#">
                        {{ $parameter->name }}
                    </a>

                    <ul>
                        @foreach($parameter->options as $option)
                        <li> {{ $option->value }} </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <h5>{{ $parameter->marks }}</h5>
                </td>
                <td>
                   <button v-on:click="editParameter({{ $parameter }})" class="btn btn-default">Edit</button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @include('hr::evaluation.parameters.create')
    @include('hr::evaluation.parameters.edit')
</div>


@endsection

@section('js_scripts')
<script>
    new Vue({
    el:'#segments_parameters_container',

    data() {
        return {
            updateRoute: "{{ route('hr.evaluation.parameter.update', [$segment->id, 'PARAMETER_ID']) }}",
            parameterOptions: [],
            selectedParameter: {},
            updateParameterOptions: []
        }
    },

    methods: {
        editParameter(parameter) {
            this.updateRoute = this.updateRoute.replace('PARAMETER_ID', parameter.id);
            this.selectedParameter = parameter;
            this.updateParameterOptions = parameter.options ? parameter.options : [];
            $('#updateParameterModal').modal('show');
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
        //alert("Hello");
    }
});

</script>

@endsection