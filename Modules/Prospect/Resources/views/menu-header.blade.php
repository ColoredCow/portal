<ul class="nav nav-pills mt-3 mb-2" role="navigation" aria-label="Prospect statuses">
    @php
        $filters = request()->except('page');
        $currentStatus = request('status', 'open');
        $prospectStatuses = ['open' => 'Open', 'converted' => 'Converted', 'rejected' => 'Rejected', 'client-unresponsive' => 'Unresponsive'];
    @endphp

    @foreach($prospectStatuses as $status => $label)
        <li class="nav-item {{ $loop->iteration ? 'mx-1' : 'mr-1' }}">
            <a class="nav-link {{ $currentStatus == $status ? 'active' : '' }}"
                href="{{ route('prospect.index', array_merge($filters, ['status' => $status])) }}" aria-current="{{ $currentStatus == $status ? 'page' : 'false'}}">
                {{ $label }}
            </a>
        </li>
    @endforeach
</ul>
