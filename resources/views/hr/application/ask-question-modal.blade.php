<div class="modal fade" id="ask_questions">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="create_slots">
            <form action="{{ route('application.round.questions', ['application'=> $applicationRound, 'round'=>$applicationRound]) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h4>Add questions</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden"name="applicationRound" value="{{$applicationRound}}" >
                    Content!!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
