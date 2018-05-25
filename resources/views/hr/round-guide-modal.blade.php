<div class="modal fade hr_round_guide" id="round_guide_{{ $round->id }}" tabindex="-1" role="dialog" aria-labelledby="round_guide_{{ $round->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('hr.round.update', $round->id) }}" method="POST">

                {{ csrf_field() }}
                {{ method_field('PATCH') }}

                <div class="modal-header">
                    <h5 class="modal-title" id="round_guide_{{ $round->id }}">Guidelines for {{ $round->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @php
                    if (empty($round->guidelines)) {
                        $guide_display = 'd-none';
                        $guide_editor = '';
                    } else {
                        $guide_display = '';
                        $guide_editor = 'd-none';
                    }
                    @endphp
                    <div class="bg-light p-3 mb-3 space-wrap guide-display guide-container {{ $guide_display }}">{!! $round->guidelines !!}</div>
                    <div class="guide-container guide-editor {{ $guide_editor }}">
                        <textarea name="guidelines" class="form-control richeditor">{!! $round->guidelines !!}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-2 px-0 float-right">
                        <input type="hidden" name="type" value="guidelines">
                        <button type="button" class="btn btn-secondary btn-block btn-guide edit-guide {{ $guide_display }}">Edit</button>
                        <button type="button" class="btn btn-primary btn-block btn-guide save-guide {{ $guide_editor }}">
                            <i class="fa fa-spinner fa-spin d-none item"></i>
                            <span class="item">Save</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
