<ul class="nav nav-pills">
    <li class="nav-item">
        @php
          $params = array_merge(['staff_type' => 'Employee'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Employee' ? 'active' : '' }}" href="{{ route('payroll',$params) }}"><i class="fa fa-users"></i>&nbsp; Employee </a>
    </li>
    <li class="nav-item">
        @php
          $params = array_merge(['staff_type' => 'Intern'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Intern' ? 'active' : '' }}" href="{{ route('payroll', $params) }}"><i class="fa fa-users"></i>&nbsp;Intern</a>
    </li>

    <li class="nav-item">
        @php 
          $params = array_merge(['staff_type' => 'Contractor'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Contractor' ? 'active' : '' }}" href="{{ route('payroll', $params) }}"><i class="fa fa-users"></i>&nbsp;Contractor</a>
    </li>

    <li class="nav-item">
        @php
          $params = array_merge(['staff_type' => 'Support Staff'], ['status' => 'current']);
        @endphp
        <a class="nav-item nav-link {{ request()->input('staff_type') === 'Support Staff' ? 'active' : '' }}" href="{{ route('payroll', $params) }}"><i class="fa fa-users"></i>&nbsp;Support Staff</a>
    </li>
</ul>
