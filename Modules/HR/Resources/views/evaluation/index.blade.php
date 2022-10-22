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
                <button class="btn btn-success" data-toggle="modal" data-target="#createNewSegment"> <i class="fa fa-plus mr-1"></i> Add New Segment</button>
            </div>  
        </div>      
        <br>

        <div class="container">
            <?php
            $count = 0;
            ?> 
            @foreach ($roundWithSegments as $key=>$round )    
            @if(sizeOf($round[key($round)]))
                <div class="accordion" id="accordion">
                <div class="accordion-header c-pointer" data-toggle="collapse" data-target="#segmentCollapse_{{ $key }}">
                        <div class="card bg-Glidden-willow-springs">
                            <div class="form-row">
                                <div class="form-group col-md-11 p-3">
                                    <h4 class="accordion-header mb-0" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{  key($round) }}
                                    </h4> 
                                </div>   
                                <div class="form-group col-md p-3">
                                </div>    
                            </div>
                        </div> 
                    </div>
                    <div id="segmentCollapse_{{ $key }}" class="collapse <?php echo($count == 0 ? 'show' : ' ')?>" aria-labelledby="headingOne">
                        <div class="accordion-body">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <th>Marks</th>
                                    <th>Actions</th>
                                </tr>
                                @foreach ($round[key($round)] as $singleRound)
                                <tr>
                                    <td>
                                        <a href="{{ route('hr.evaluation.segment-parameters', $singleRound->id) }}">
                                            {{ $singleRound->name }}
                                        </a>
                                    </td>
                                    
                                    <td>
                                        <h5>{{ $singleRound->parameters->sum('marks') }}</h5>
                                    </td>
                                    
                                    <td>
                                        <i v-on:click="editSegment({{ $singleRound }})" class="fa fa-edit fz-20 text-theme-green"></i>
                                    
                                        <i v-on:click="removeSegment({{ $singleRound }})" class="fa fa-trash fz-20 text-theme-red"></i>
                                    </td>
                                </tr>
                                @endforeach 
                            </table>       
                        </div>              
                    </div>
                </div>
                <br>
                <?php $count++ ?>
            @endif
            @endforeach
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