<ul class="nav nav-pills mb-6">
    @can('user_management.view')
        <li class="nav-item">
            <a class="nav-item nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user.index')  }}"><i class="fa fa-users"></i>&nbsp;Users</a>
        </li>
    @endcan
    @can('user_role_management.view')
        <li class="nav-item">
            <a class="nav-item nav-link {{ Request::is('user/roles') ? 'active' : '' }}" href="{{ route('user.role-index') }}"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
        </li>
    @endcan
</ul>
