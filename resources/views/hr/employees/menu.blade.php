<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employees*') ? 'active' : '' }}" href="{{ route('employees') }}"><i class="fa fa-users"></i>&nbsp;Employees</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employee-reports*') ? 'active' : '' }}" href="{{ route('employees.reports') }}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
</ul>
