<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ (Request::is('hr/employees*') && !Request::is('salary/employee*')) ? 'active' : '' }}" href="{{ route('employees') }}"><i class="fa fa-users"></i>&nbsp;Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ (Request::is('salary/employee*')) ? 'active' : '' }}" href="{{ route('salary.employee') }}"><i class="fa fa-rupee"></i>&nbsp;Salary</a>
    </li>
</ul>