<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/requisition*') ? 'active' : '' }}" href="{{ route('requisition') }}"><i class="fa fa-users"></i>&nbsp;Pending</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/complete*') ? 'active' : '' }}" href="{{ route('requisition.complete') }}"><i class="fa fa-users"></i>&nbsp;Complete</a>
    </li>
</ul>
