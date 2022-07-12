  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" role="document">
    
      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header">
          <h4 class="modal-title">Total Open Applications</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          
          @foreach ($rounds as $round)
          @php
          $roundWiseCount = camel_case($round).'Count';

          @endphp
          <div class="d-flex">
            <p>{{$round}} </p>
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
</div>
  