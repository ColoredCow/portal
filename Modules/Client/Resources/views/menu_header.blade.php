<ul class="nav nav-pills my-3">
    <li class="nav-item mr-3">
        <a class="nav-link {{ (request()->input('status', 'active') == 'active') ? 'active' : '' }}" href="{{ route('client.index', ['status' => 'active'])  }}">Active Clients</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ (request()->input('status', 'active') == 'inactive') ? 'active' : '' }}"  href="{{ route('client.index', ['status' => 'inactive'])  }}">Inactive Clients</a>
    </li>
</ul>