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
        <div class="d-flex justify-content-between">
            <h1 class="mb-0">Rounds and Segments</h1>
            <div>
                <button class="btn btn-primary" data-toggle="modal" data-target="#createNewSegment">Add New</button>
            </div>
        </div>      
    </div>
     <br>
        <table class="table ">
            
            @foreach ($rounds as $round)
                    <a >
                    @foreach ($segments as $segment)
                    <tr>
                        @if($round->id == $segment->round_id )
                        <td>
                            <div class="card-header c-pointer" data-toggle="collapse" data-target="#applicant_verification{{$round->id}}" aria-expanded="true" aria-controls="applicant_verification"> {{$round->name}}
                            </div>
		                        <div id="applicant_verification{{$round->id}}" class="collapse">
			                      <div class="card-body">
      @foreach($segments as $segment )
      @if($round->id == $segment->round_id )
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
              <div class="row">
            <div class="col-md-10">
							<label for="setting_key[applicant_verification_subject]">    <a href="{{ route('hr.evaluation.segment-parameters', $segment->id) }}">
                        {{ $segment->name }}
                        </a></label>
</div>
                        <div class="col-md-2">
                    <i v-on:click="editSegment({{ $segment }})" class="fa fa-edit fz-20 text-theme-green"></i>
                    <i class="fa fa-trash fz-20 ml-4 text-theme-red"></i>
</div>
</div>
            </div>
					</div>
				</div>  
      @endif             
      @endforeach      
      </div>
    </div>               
            @break
                      @endif  
            </tr>
                  @endforeach
                    </a>
                    <h5></h5>
                </td> 
            </tr>
         @endforeach
        </table>
    </div>
@include('hr::evaluation.segment.create')
@include('hr::evaluation.segment.edit')
</div>
@endsection
@section('js_scripts')
<script>
    new Vue({
    el:'#segments_container',

    data() {
        return {
            updateRoute: "{{ route('hr.evaluation.segment.update', 'SEGMENT_ID') }}",
            segmentName: ''
        }
    },

    methods: {
        editSegment(segment) {
            this.updateRoute = this.updateRoute.replace('SEGMENT_ID', segment.id);
            this.segmentName = segment.name;
            $('#editSegmentModal').modal('show');
        }
    }
});

</script>

@endsection 
