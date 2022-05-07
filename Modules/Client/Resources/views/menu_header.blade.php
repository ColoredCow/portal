<ul class="nav nav-pills">
    @php
        $request = request()->all();
    @endphp
    <li class="nav-item mr-3">
        @php
            $request['status'] = 'active';
        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'active')  ? 'active' : '' }}" href="{{ route('client.index', $request)  }}">Active Clients</a>
    </li>

    <li class="nav-item">
        @php
            $request['status'] = 'inactive';
        @endphp
        <a class="nav-link {{ (request()->input('status', 'active') == 'inactive') ? 'active' : '' }}"  href="{{ route('client.index', $request)  }}">Inactive Clients</a>
    </li>
</ul>