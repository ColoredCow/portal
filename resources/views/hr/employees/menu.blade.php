<ul class="nav nav-pills">
    <li class="nav-item">
        @php
          $params = array_merge(['staff_type' => 'Employee'], ['status' => 'current']);
          $route_name = Route::getCurrentRoute()->getName();
        @endphp

        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Employee' ? 'active' : '' }}" href="{{ route($route_name,$params) }}"><i class="fa fa-users"></i>&nbsp; Employees </a>
    </li>
    <li class="nav-item">
        @php
          $params = array_merge(['staff_type' => 'Intern'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Intern' ? 'active' : '' }}" href="{{ route($route_name, $params) }}"><i class="fa fa-users"></i>&nbsp;Intern</a>
    </li>

    <li class="nav-item">
        @php 
          $params = array_merge(['staff_type' => 'Contractor'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Contractor' ? 'active' : '' }}" href="{{ route($route_name, $params) }}"><i class="fa fa-users"></i>&nbsp;Contractor</a>
    </li>

    <li class="nav-item">
        @php
          $params = array_merge(['staff_type' => 'Support Staff'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Support Staff' ? 'active' : '' }}" href="{{ route($route_name, $params) }}"><i class="fa fa-users"></i>&nbsp;Support Staff</a>
    </li>

    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/employee-reports*') ? 'active' : '' }}" href="{{ route($route_name) }}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
</ul>
