    <div class="modal fade" id="exampleModal{{$project->id}}" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">REMOVE</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('project.destroy', $project->id) }}" method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="name"><span>Reason for Deletion</span></label>
                        <input type="text" class="form-control" name="comment">
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button class="btn btn-primary" onclick="">Yes</button> 
                </form>
            </div>
        </div>
    </div>
</div> 
