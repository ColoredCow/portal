<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'clients' ? 'active' : '' }}" href="/clients"><i class="fa fa-users"></i>&nbsp;Clients</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'projects' ? 'active' : '' }}" href="/projects"><i class="fa fa-desktop"></i>&nbsp;Projects</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'invoices' ? 'active' : '' }}" href="/finance/invoices"><i class="fa fa-folder-open"></i>&nbsp;Invoices</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'reports' ? 'active' : '' }}"
        href="/finance/reports?start={{ (new \Carbon\Carbon('first day of last month'))->format(config('constants.date_format')) }}&end={{ (new \Carbon\Carbon('last day of last month'))->format(config('constants.date_format')) }}">
            <i class="fa fa-line-chart"></i>&nbsp;Reports
        </a>
    </li>
</ul>
