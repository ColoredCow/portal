<ul class="nav nav-pills mb-3 px-3">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Route::currentRouteName() === 'user.index' ? 'active' : '' }}" href="{{ route('user.index')  }}"><i class="fa fa-users"></i>&nbsp;Users</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Route::currentRouteName() === 'user.role.index' ? 'active' : '' }}" href="{{ route('user.role.index') }}"><i class="fa fa-list-ul"></i>&nbsp;Roles</a>
    </li>
</ul>
