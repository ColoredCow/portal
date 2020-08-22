<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/universities*') ? 'active' : '' }}" href="{{ route('universities') }}"><i class="fa fa-university"></i>&nbsp;Universities</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/universities/reports') ? 'active' : '' }}" href="{{route('universities.reports')}}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
</ul>
