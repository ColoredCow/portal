@extends('hr::layouts.master')
@section('content')
<div class="container" id="segments_container">
    <br>
    <br>
    <div> 
        <div class="d-none alert alert-success fade show" role="alert" id="segmentsuccess">
            <strong>Success!!!</strong>Congratulations!!! New segment successfully created.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="d-none alert alert-success fade show" role="alert" id="editSegmentSuccess">
            <strong>Success!</strong>Segment updated successfully.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="d-flex justify-content-between">
            <h1 class="mb-0">Segments</h1>
            <div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createNewSegment">Add New</button>
            </div>
        </div>      
        <br>

        <div class="container">
            @foreach ($rounds as $round)
            @foreach ($attr as $key=>$segment)
            @if ($round->id == $key)
            <div class="accordion" id="accordion">
                <div class="accordion-item">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <h2 class="accordion-header mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            {{ $round->name }}
                                        </button>
                                    </h2> 
                                </div>   
                                <div class="form-group col-md">
                                    <div class="icon-pencil position-relative ml-3 c-pointer" data-toggle="collapse" data-target="#segmentCollapse_{{ $round->id }}">
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                </div>     
                            </div>
                        </div>
                    </div> 
                </div>
            </div>               
            <div id="segmentCollapse_{{ $round->id }}" class="collapse" aria-labelledby="headingOne">
                <div class="accordion-body">
                    @foreach ($segment as $value)
                    <div class="card-body">
                        <div class="d-flex flex-row d-flex justify-content-between">
                            <h1 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <a href="{{ route('hr.evaluation.segment-parameters', $value->id) }}">
                                    {{ $value->name }}</a>       
                                </button>
                            </h1>
                            <h5>
                                {{ $value->parameters->sum('marks') }}
                            </h5>
                            <i v-on:click="editSegment({{ $value }})" class="fa fa-edit fz-20 text-theme-green"></i>

                            <i v-on:click="removeSegment({{ $value }})" class="fa fa-trash fz-20 text-theme-red"></i>
                        </div>      
                    </div>
                    @endforeach    
                </div>
            </div>    
            @endif 
            @endforeach
            @endforeach
        </div>
    </div>

</div>

@include('hr::evaluation.segment.create')
@include('hr::evaluation.segment.edit')
@include('hr::evaluation.segment.delete')
</div>
@endsection

@section('js_scripts')
<script>
    new Vue({
    el:'#segments_container',

    data() {
        return {
            initialUpdateRoute: "{{ route('hr.evaluation.segment.update', 'SEGMENT_ID') }}",
            updateRoute: "{{ route('hr.evaluation.segment.update', 'SEGMENT_ID') }}",
            segmentName: '',
            segmentRoundId : '',
            initialDeleteRoute: "{{ route('hr.evaluation.segment.delete', 'SEGMENT_ID') }}",
            deleteRoute: "{{ route('hr.evaluation.segment.delete', 'SEGMENT_ID') }}",
        }
    },

    methods: {
        editSegment(segment) {
            this.updateRoute = this.initialUpdateRoute;
            this.updateRoute = this.updateRoute.replace('SEGMENT_ID', segment.id);
            this.segmentName = segment.name;
            this.segmentRoundId = segment.round_id;
            $('#editSegmentModal').modal('show');
        },

        removeSegment(segment) {
            this.deleteRoute = this.initialDeleteRoute;
            this.deleteRoute = this.deleteRoute.replace('SEGMENT_ID', segment.id);
            this.segmentName = segment.name;
            $('#deleteSegmentModal').modal('show');
        }
    }
});

</script>

@endsection