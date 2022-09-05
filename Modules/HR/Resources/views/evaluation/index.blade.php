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

        <table class="table table-striped table-bordered">
            <tr>
                <th>Name</th>
                <th>Marks</th>
                <th>Actions</th>
            </tr>
            @foreach ($segments as $segment)
            <tr>
                <td>
                    <a href="{{ route('hr.evaluation.segment-parameters', $segment->id) }}">
                        {{ $segment->name }}
                    </a>
                </td>

                <td>
                    <h5>{{ $segment->parameters->sum('marks') }}</h5>
                </td>

                <td>
                    <i v-on:click="editSegment({{ $segment }})" class="fa fa-edit fz-20 text-theme-green"></i>

                    <i v-on:click="removeSegment({{ $segment }})" class="fa fa-trash fz-20 text-theme-red"></i>
                </td>
            </tr>
            @endforeach
        </table>

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