<div class="mb-2">
    <form class="d-md-flex justify-content-between ml-2 my-3"
        action="{{ route('project.index', ['status' => 'visitors_log']) }}">
        <div class='d-flex justify-content-between align-items-md-center mb-2 mb-xl-0'>
            <h4 class="">
                Visitor Log
            </h4>
            <input type="hidden" name="status" value="{{ $status }}">
            <select class="fz-14 fz-lg-16 p-1 bg-info ml-3 my-auto text-white rounded border-0" name="visit_interval"
                onchange="this.form.submit()">
                <option
                    value="daily"
                    {{ request()->get('visit_interval') == 'daily' ? 'selected' : '' }}
                >
                    {{ __('Daily') }}
                </option>

                <option
                    value="weekly"
                    {{ request()->get('visit_interval') == 'weekly' ? 'selected' : '' }}
                >
                    {{ __('Weekly') }}
                </option>

                <option 
                    value="monthly"
                    {{ request()->get('visit_interval') == 'monthly' ? 'selected' : '' }}
                >
                    {{ __('Monthly') }}
                </option>
            </select>
        </div>
    </form>

    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S. No.</th>
                    <th scope="col">Name</th>
                    <th scope="col">Page Path</th>
                    <th scope="col">Visit Count</th>
                    <th scope="col">Visit Date</th>
                  </tr>
            </thead>
            <tbody>
                @foreach ($visitor_logs as $visitor_log)
                    @php
                        $user = $visitor_log->user()->withTrashed()->first();
                    @endphp
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ optional($user)->name }}</td>
                        <td>{{ $visitor_log->page_path }}</td>
                        <td>{{ $visitor_log->visit_count }}</td>
                        <td>{{ $visitor_log->created_at->format(config('constants.full_display_date_format')) }}</td>
                    </tr>
                @endforeach
              </tbody>
        </table>
    </div>
</div>