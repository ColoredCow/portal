<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/job*') ? 'active' : '' }}" href="/hr/jobs"><i class="fa fa-list-ul"></i>&nbsp;Programs</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/applications/volunteers*') ? 'active' : '' }}" href="{{ route('applications.volunteers') }}"><i class="fa fa-users"></i>&nbsp;Applications</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/volunteers/reports*') ? 'active' : '' }}" href="{{ route('volunteers.reports') }}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/volunteers/campaigns*') ? 'active' : '' }}" href="{{ route('volunteers.campaigns') }}"><i class="fa fa-envelope"></i>&nbsp;Campaigns</a>
    </li>
</ul>
