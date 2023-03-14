<ul class="nav nav-pills mt-3 mb-2">
    @php
        $filters = request()->except('page');
    @endphp

    <li class="nav-item mr-3">
        <a class="nav-link {{ request()->input('is_amc', '0') == '0' && request()->input('status', 'active') == 'active' ? 'active' : '' }}"
            href="{{ route('project.index', array_merge($filters, ['status' => 'active', 'is_amc' => '0'])) }}">
            Main Projects({{ $mainProjectsCount }})</a>
    </li>

    <li class="nav-item">
        <a class="nav-link  {{ request()->input('is_amc', '0') == 1 ? 'active' : '' }}"
            href="{{ route('project.index', array_merge($filters, ['status' => 'active', 'is_amc' => '1'])) }}">AMC
            Projects({{ $AMCProjectCount }})</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->input('status', 'active') == 'halted' ? 'active' : '' }}"
            href="{{ route('project.index', array_merge($filters, ['status' => 'halted', 'is_amc' => '0'])) }}">Halted
            Projects({{ $haltedProjectsCount }})</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ request()->input('status', 'active') == 'inactive' ? 'active' : '' }}"
            href="{{ route('project.index', array_merge($filters, ['status' => 'inactive', 'is_amc' => '0'])) }}">Inactive
            Projects({{ $inactiveProjectsCount }})</a>
    </li>
</ul>
