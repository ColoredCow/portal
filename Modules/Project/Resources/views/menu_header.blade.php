<ul class="nav nav-pills my-3">
    @php
        $request = request()->all();
    @endphp
    <li class="nav-item mr-3">
        @php
            $request['status'] = 'active';
        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'active') ? 'active' : '' }}" href="{{ route('project.index', $request)  }}">Active Projects</a>
    </li>

    <li class="nav-item">
        @php
            $request['status'] = 'halted';
        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'halted') ? 'active' : '' }}" href="{{ route('project.index', $request)  }}">Halted Projects</a>
    </li>

    <li class="nav-item">
        @php
            $request['status'] = 'inactive';
        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'inactive') ? 'active' : '' }}"  href="{{ route('project.index', $request)  }}">Inactive Projects</a>
    </li>
</ul>