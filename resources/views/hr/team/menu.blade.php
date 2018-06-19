<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/team*') ? 'active' : '' }}" href="{{ route('team') }}"><i class="fa fa-users"></i>&nbsp;Team</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/applications/internship*') ? 'active' : '' }}" href="#"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
</ul>
