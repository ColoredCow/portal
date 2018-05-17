<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'jobs' ? 'active' : '' }}" href="/hr/jobs"><i class="fa fa-list-ul"></i>&nbsp;Jobs</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/applications/job*') ? 'active' : '' }}" href="{{ route('applications.job.index') }}"><i class="fa fa-users"></i>&nbsp;Job Applications</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/applications/internship*') ? 'active' : '' }}" href="{{ route('applications.internship.index') }}"><i class="fa fa-university"></i>&nbsp;Interships Applications</a>
    </li>
</ul>
