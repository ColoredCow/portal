<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ (Request::is('hr/universities*') && !Request::is('hr/universities/reports*')) ? 'active' : '' }}" href="{{ route('universities.index') }}"><i class="fa fa-university"></i>&nbsp;Universities</a>
    </li>
</ul>