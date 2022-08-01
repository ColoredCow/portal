<div class="row">
    <div class="col-12">
        <div class="d-flex flex-wrap">
            @foreach($segment as $evaluation_segment)
                @continue(strtolower($evaluation_segment['name']) == 'resume feeling')
                @include('hr::evaluation.applicationround-segment-evaluation')
            @endforeach
        </div>
    </div>
</div>
