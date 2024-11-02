<ul class="nav nav-pills mt-3 mb-2">
    @php
        $filters = request()->except('page');
        $currentStatus = request()->input('status') ?? 'open';
    @endphp

    <li class="nav-item mr-3">
        <a class="nav-link {{ $currentStatus == 'open' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'open'])) }}">
            Open Prospects
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $currentStatus == 'converted' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'converted'])) }}">
            Converted Prospects
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $currentStatus == 'rejected' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'rejected'])) }}">
            Rejected Prospects
        </a>
    </li>
</ul>
