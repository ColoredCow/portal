<div class="card-header d-flex mt-5" data-toggle="collapse" data-target="#prospect-comments">
    <h5 class="font-weight-bold">Prospect Comments ({{ count($prospect->comments) }})</h5>
    <span class ="arrow ml-auto">&#9660;</span>
</div>
<div id="prospect-comments" class="collapse card mt-3">
    <div class="panel-body">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="font-weight-bold">Comments</h5>
            </div>
            @foreach ($prospect->comments as $comment)
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $comment->user->avatar }}" alt="User" class="rounded-circle mr-5"
                            width="50" data-toggle="tooltip" data-placement="top" title={{ $comment->user->name }}>
                        <div>
                            <span
                                class="fz-16 font-weight-bold text-muted">{{ $prospect->getFormattedDate($comment->created_at) }}</span>
                            <h5>{{ $comment->comment }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
            @if (count($prospect->comments) == 0)
                <div class="card">
                    <div class="card-body">
                        <h5 class="font-weight-bold">No Comments</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
