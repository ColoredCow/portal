<ul class="nav nav-pills">
    @can('clients.view')
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'clients' ? 'active' : '' }}" href="/clients"><i class="fa fa-users"></i>&nbsp;Clients</a>
    </li>
    @endcan
    @can('projects.view')
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'projects' ? 'active' : '' }}" href="/projects"><i class="fa fa-desktop"></i>&nbsp;Projects</a>
    </li>
    @endcan
    @can('finance_invoices.view')
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'invoices' ? 'active' : '' }}" href="/finance/invoices"><i class="fa fa-folder-open"></i>&nbsp;Invoices</a>
    </li>
    @endcan
    @can('finance_reports.view')
    <li class="nav-item">
        <a href="/finance/reports?show=default" class="nav-item nav-link {{ $active === 'reports' ? 'active' : '' }}">
            <i class="fa fa-line-chart"></i>&nbsp;Reports
        </a>
        </a>
    </li>
    @endcan
</ul>
