<div>
    <div class="card p-5">
        <div class="row">
            <div class="col-12">
                <a class="btn btn-info btn-sm float-right" href="{{ route('prospect.edit', $prospect) }}"> Edit</a>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div>
                    <div class="font-weight-bold">Name</div>
                    <span>{{ $prospect->name }}</span>
                </div>
                <br>
                <div>
                    <div class="font-weight-bold">Added on</div>
                    <span>{{ $prospect->created_at->diffForHumans() }}</span>
                </div>
                <br>
                <div>
                    <div class="font-weight-bold">Assign To</div>
                    <span>{{ optional($prospect->assignTo)->name }}</span>
                </div>
                <br>
                <div>
                    <div class="font-weight-bold">Brif Info</div>
                    <span>{{ $prospect->brief_info }}</span>
                </div>
            </div>
            <div class="col-5 offset-1">
                <div>
                    <div class="font-weight-bold">Status</div>
                    <div>{{ 'Active' }}</div>
                </div>
                <br>
                <div>
                    <div class="font-weight-bold">Added by</div>
                    <div>{{ $prospect->createdBy->name }}</div>
                </div>
                <br>

                <div>
                    <div class="font-weight-bold">Coming From</div>
                    <div>{{ \Str::title($prospect->coming_from)  }}</div>
                </div>

                <br>
                <div>
                    <div class="font-weight-bold">Contact person</div>
                    <div>
                        <ul class="d-flex flex-row flex-wrap justify-content-between list-group list-style-none pt-3">
                            @foreach($prospect->contactPersons as $contactPerson)
                            <li class="mb-2">
                                <div>{{ $contactPerson->name }}</div>
                                <div class="text-muted">{{ $contactPerson->email }}</div>
                                <div class="text-muted">{{ $contactPerson->phone }}</div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>