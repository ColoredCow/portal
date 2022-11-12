<ul class="nav nav-pills">
    <li class="nav-item">
        @php
          $params = array_merge(['name' => 'Employee'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('name') === 'Employee' ? 'active' : '' }}" href="{{ route('employees',$params) }}"><i class="fa fa-users"></i>&nbsp; Employees </a>
    </li>
    <li class="nav-item">
        @php
          $params = array_merge(['name' => 'Intern'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('name') === 'Intern' ? 'active' : '' }}" href="{{ route('employees', $params) }}"><i class="fa fa-users"></i>&nbsp;Intern</a>
    </li>

    <li class="nav-item">
        @php 
          $params = array_merge(['name' => 'Contractor'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('name') === 'Contractor' ? 'active' : '' }}" href="{{ route('employees', $params) }}"><i class="fa fa-users"></i>&nbsp;Contractor</a>
    </li>

    <li class="nav-item">
        @php
          $params = array_merge(['name' => 'Support Staff'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('name') === 'Support Staff' ? 'active' : '' }}" href="{{ route('employees', $params) }}"><i class="fa fa-users"></i>&nbsp;Support Staff</a>
    </li>

    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employee-reports*') ? 'active' : '' }}" href="{{ route('employees.reports') }}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
</ul>
