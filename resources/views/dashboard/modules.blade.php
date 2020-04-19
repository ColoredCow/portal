<ul class="nav nav-pills">
    @if(Module::isEnabled('User') && auth()->user()->can('user_management.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('user.index') }}"><i class="fa fa-users"></i>&nbsp;User Management</a>
    </li>
    @endif

    @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view',
    'hr_volunteers_applications.view']))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('hr') }}"><i class="fa fa-list"></i>&nbsp;HR</a>
    </li>
    @endif

    @can('finance_invoices.view')
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{route('invoices')}}"><i class="fa fa-university"></i>&nbsp;Finance</a>
    </li>
    @endcan

    @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="{{ route('knowledgecafe') }}"><i class="fa fa-pie-chart"></i>&nbsp;KnowledgeCafe</a>
        </li>
    @endif


    @if(auth()->user()->hasAnyPermission(['crm_talent.view', 'crm_client.view']))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="{{ route('crm') }}"><i class="fa fa-bar-chart"></i>&nbsp;CRM</a>
        </li>
    @endif

    @if(auth()->user()->can('infrastructure.view'))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="{{ route('infrastructure.index') }}"><i class="fa fa-bar-chart"> </i>&nbsp;Infrastructure</a>
        </li>
    @endif

</ul>
