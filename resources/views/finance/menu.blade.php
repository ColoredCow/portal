<ul class="nav nav-pills">
    @can('finance_reports.view')
        <li class="nav-item">
            <a href="/finance/reports?type=monthly" class="nav-item nav-link {{ $active === 'reports' ? 'active' : '' }}">
                <i class="fa fa-line-chart"></i>&nbsp;Reports
            </a>
            </a>
        </li>
    @endcan
</ul>
