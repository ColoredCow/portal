<!-- Modal -->
<div class="modal fade" id="countIcon" tabindex="-1" role="dialog" aria-labelledby="totalCount" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="totalCount">Total Count Application</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      @foreach ($rounds as $round)
          @php
          $roundWiseCount = camel_case($round).'Count';

          @endphp
          <div class="d-flex">
            <p>{{$round}}</p>&nbsp;{{ '-' }}&nbsp;
            <p>{{$$roundWiseCount}} </p> 
          </div>
          @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>