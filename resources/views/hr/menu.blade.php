<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/recruitment/opportunities*') ? 'active' : '' }}" href="{{ route('recruitment.opportunities') }}"><i class="fa fa-list-ul"></i>&nbsp;Opportunities</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/recruitment/job*') ? 'active' : '' }}" href="{{ route('applications.job.index') }}"><i class="fa fa-users"></i>&nbsp;Job Applications</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/recruitment/internship*') ? 'active' : '' }}" href="{{ route('applications.internship.index') }}"><i class="fa fa-university"></i>&nbsp;Internship Applications</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/recruitment/reports*') ? 'active' : '' }}" href="{{ route('recruitment.reports') }}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/recruitment/campaigns*') ? 'active' : '' }}" href="{{ route('recruitment.campaigns') }}"><i class="fa fa-envelope"></i>&nbsp;Campaigns</a>
    </li>
    </li>
    <li class="nav-item c-pointer" data-toggle="modal" data-target="#countIcon">
        <a class="nav-item nav-link"><i class="fa fa-bitbucket" aria-hidden="true"></i>&nbsp;Total Count</a>
    </li>
</ul>
