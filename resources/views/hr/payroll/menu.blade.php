<div class="d-flex justify-content-between">
  <div>
    <ul class="nav nav-pills">
        <li class="nav-item">
            @php
              $params = array_merge(['staff_type' => 'Employee']);
            @endphp
            <a class="nav-item nav-link {{ request()->input('staff_type') === 'Employee' ? 'active' : '' }}" href="{{ route('payroll',$params) }}"><i class="fa fa-users"></i>&nbsp; Employee </a>
        </li>
        <li class="nav-item">
            @php
              $params = array_merge(['staff_type' => 'Intern']);
            @endphp
            <a class="nav-item nav-link {{ request()->input('staff_type') === 'Intern' ? 'active' : '' }}" href="{{ route('payroll', $params) }}"><i class="fa fa-users"></i>&nbsp;Intern</a>
        </li>

        <li class="nav-item">
            @php
              $params = array_merge(['staff_type' => 'Contractor']);
            @endphp
            <a class="nav-item nav-link {{ request()->input('staff_type') === 'Contractor' ? 'active' : '' }}" href="{{ route('payroll', $params) }}"><i class="fa fa-users"></i>&nbsp;Contractor</a>
        </li>

        <li class="nav-item">
            @php
              $params = array_merge(['staff_type' => 'Support Staff']);
            @endphp
            <a class="nav-item nav-link {{ request()->input('staff_type') === 'Support Staff' ? 'active' : '' }}" href="{{ route('payroll', $params) }}"><i class="fa fa-users"></i>&nbsp;Support Staff</a>
        </li>
    </ul>
  </div>
  <div>
    <form method="POST" action="{{ route('payroll-download') }}">
      @csrf
      <div class="d-flex align-items-center">
        <select name="export" class="p-0.5">
          <option value="full-time">Employee Salary</option>
          <option value="contractor">Contractor Fee</option>
        </select>
        <button type="submit" class="ml-1 btn btn-primary">Export</button>
      </div>
    </form>
  </div>
</div>
