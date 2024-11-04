<div class="card-header d-flex mt-5" data-toggle="collapse" data-target="#prospect-insights" role="button"
    aria-expanded="false" aria-controls="prospect-insights">
    <h5 class="font-weight-bold">Prospect Insights / Learning ({{ count($prospect->insights) }})</h5>
    <span class ="arrow ml-auto">&#9660;</span>
</div>
<div id="prospect-insights" class="collapse card mt-3">
    <div class="panel-body">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5 class="font-weight-bold">Prospect Insights</h5>
            </div>
            @foreach ($prospect->insights as $key => $insight)
                <div class="mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $insight->user->avatar }}" alt="User" class="rounded-circle mr-5"
                            width="50" data-toggle="tooltip" data-placement="top" title={{ $insight->user->name }}>
                        <div>
                            <span
                                class="fz-16 font-weight-bold text-muted">{{ \Carbon\Carbon::parse($insight->created_at)->format('M d, Y') }}</span>
                            <h5>{{ $insight->insight_learning }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
            @if (count($prospect->insights) == 0)
                <div class="card">
                    <div class="card-body">
                        <h5 class="font-weight-bold">No Insights</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
