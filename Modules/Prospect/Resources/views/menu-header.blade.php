<ul class="nav nav-pills mt-3 mb-2" role="navigation" aria-label="Prospect statuses">
    @php
        $filters = request()->except('page');
        $currentStatus = request()->input('status') ?? 'open';
    @endphp

    <li class="nav-item mr-1">
        <a class="nav-link {{ $currentStatus == 'open' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'open'])) }}" aria-current="{{ $currentStatus == 'open' ? 'page' : 'false'}}">
            Open
        </a>
    </li>
    <li class="nav-item mx-1">
        <a class="nav-link {{ $currentStatus == 'converted' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'converted'])) }}" aria-current="{{ $currentStatus == 'converted' ? 'page' : 'false'}}">
            Converted
        </a>
    </li>
    <li class="nav-item mx-1">
        <a class="nav-link {{ $currentStatus == 'rejected' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'rejected'])) }}" aria-current="{{ $currentStatus == 'rejected' ? 'page' : 'false'}}">
            Rejected
        </a>
    </li>
    <li class="nav-item ml-1">
        <a class="nav-link {{ $currentStatus == 'client-unresponsive' ? 'active' : '' }}"
            href="{{ route('prospect.index', array_merge($filters, ['status' => 'client-unresponsive'])) }}" aria-current="{{ $currentStatus == 'client-unresponsive' ? 'page' : 'false'}}">
            Unresponsive
        </a>
    </li>
</ul>
