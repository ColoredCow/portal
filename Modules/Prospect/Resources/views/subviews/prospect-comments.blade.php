<div class="card-header d-flex mt-5" data-toggle="collapse" data-target="#prospect-comments">
    <h5 class="font-weight-bold">Prospect Comments</h5>
    <span class ="arrow ml-auto">&#9660;</span>
</div>
<div id="prospect-comments" class="collapse card mt-3">
    <div class="panel-body">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="font-weight-bold">Comments</h5>
            </div>
            @foreach ($prospect->comments as $comment)
                <div class="card mb-3">
                    <div class="card-header d-flex">
                        <h5 class="font-weight-bold">{{ $comment->comment }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Commented By: {{ $comment->user->name }}</p>
                        <p class="card-text">Commented At: {{ $comment->created_at }}</p>
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
