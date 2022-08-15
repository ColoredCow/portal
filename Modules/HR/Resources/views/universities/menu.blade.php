<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ (Request::is('hr/universities*') && !Request::is('hr/universities/reports*')) ? 'active' : '' }}" href="{{ route('universities.index') }}"><i class="fa fa-university"></i>&nbsp;Universities</a>
    </li>
    @if (!Request::is('hr/universities'))
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/universities/{universiry}/reports*') ? 'active' : '' }}" href="{{route('hr.universities.reports.show',$university)}}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
    @endif
</ul>