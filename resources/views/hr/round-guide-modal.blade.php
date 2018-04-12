<div class="modal fade hr_round_guide" id="round_guide_{{ $round->id }}" tabindex="-1" role="dialog" aria-labelledby="round_guide_{{ $round->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/hr/rounds/{{ $round->id }}" method="POST">

                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="modal-header">
                    <h5 class="modal-title" id="round_guide_{{ $round->id }}">Guidelines for {{ $round->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="bg-light p-3 mb-3 space-wrap guide-container">{!! $round->guidelines !!}</div>
                        <div class="guide-container guide-editor d-none">
                            <textarea name="guidelines" class="form-control richeditor">{!! $round->guidelines !!}</textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-guide edit-guide">Edit</button>
                    <button type="submit" class="btn btn-primary d-none btn-guide save-guide">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
