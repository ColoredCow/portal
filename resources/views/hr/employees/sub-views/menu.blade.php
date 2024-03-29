<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employees*') && !Request::is('salary/employee*') ? 'active' : '' }}"
            href="{{ route('employees.show', $employee) }}"><i class="fa fa-user"></i>&nbsp;Dashboard</a>
    </li>
    @can('employee_salary.view')
        <li class="nav-item">
            <a class="nav-item nav-link {{ Request::is('salary/employee*') ? 'active' : '' }}"
                href="{{ route('salary.employee', $employee) }}"><i class="fa fa-rupee"></i>&nbsp;Salary</a>
        </li>
    @endcan
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employee-basic-details*') ? 'active' : ' ' }}"
            href="{{ route('employees.basic.details', $employee) }}"><i class="fa fa-details"></i>&nbsp;Basic
            Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employee-review-details*') ? 'active' : ' ' }}"
            href="{{ route('employees.review-details', $employee) }}"><i class="fa fa-details"></i>&nbsp;Review Details
        </a>
    </li>
</ul>
