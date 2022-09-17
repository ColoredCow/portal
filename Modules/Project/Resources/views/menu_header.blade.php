<ul class="nav nav-pills my-3">
    @php
        $request = request()->except('page');
    @endphp
    <li class="nav-item mr-3">
        @php
            $request['status'] = 'active';
            $request['is_amc'] = '0';
            $isActive =  request()->input('is_amc', '0') == '0'
        @endphp
        <a class="nav-link {{  $isActive ? 'active' : '' }}" href="{{ route('project.index', $request)  }}">Main Projects({{ $activeProjectsCount}})</a>
    </li>

    <li class="nav-item">
        @php
            $request['is_amc'] = '1';

        @endphp
        <a class="nav-link  {{ (request()->input('is_amc', 0) == 1) ? 'active' : '' }}" href="{{ route('project.index', $request)  }}">AMC Projects({{ $AMCProjectCount }})</a>
    </li>

    <li class="nav-item">
        @php
            $request['status'] = 'halted';
            $request['is_amc'] = request()->input('is_amc', 0);

        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'halted') ? 'active' : '' }}" href="{{ route('project.index', $request)  }}">Halted Projects({{ $haltedProjectsCount}})</a>
    </li>

    <li class="nav-item">
        @php
            $request['status'] = 'inactive';
            $request['is_amc'] = request()->input('is_amc', 0);

        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'inactive') ? 'active' : '' }}"  href="{{ route('project.index', $request)  }}">Inactive Projects({{$inactiveProjectsCount}})</a>
    </li>
</ul>