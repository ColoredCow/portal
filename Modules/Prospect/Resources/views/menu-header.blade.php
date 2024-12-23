<ul class="nav nav-pills mt-3 mb-2">
    @php
        $filters = request()->except('page');
        $currentStatus = request()->input('status') ?? 'open';
    @endphp

    <li class="nav-item mr-1">
        <a class="nav-link {{ $currentStatus == 'open' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'open'])) }}">
            Open
        </a>
    </li>
    <li class="nav-item mx-1">
        <a class="nav-link {{ $currentStatus == 'converted' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'converted'])) }}">
            Converted
        </a>
    </li>
    <li class="nav-item mx-1">
        <a class="nav-link {{ $currentStatus == 'rejected' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'rejected'])) }}">
            Rejected
        </a>
    </li>
    <li class="nav-item ml-1">
        <a class="nav-link {{ $currentStatus == 'client-unresponsive' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'client-unresponsive'])) }}">
            Unresponsive
        </a>
    </li>
</ul>
