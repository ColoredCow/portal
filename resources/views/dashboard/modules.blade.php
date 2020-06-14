<ul class="nav nav-pills fz-16">
    @if(Module::isEnabled('User') && auth()->user()->can('user_management.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('user.index') }}"><i
                class="fa fa-users"></i>&nbsp;User Management</a>
    </li>
    @endif

    @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view',
    'hr_volunteers_applications.view']))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('hr') }}"><i class="fa fa-list"></i>&nbsp;HR</a>
    </li>
    @endif

    {{-- @can('finance_invoices.view')
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{route('invoices')}}"><i
        class="fa fa-university"></i>&nbsp;Finance</a>
    </li>
    @endcan --}}

    @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('knowledgecafe') }}"><i
                class="fa fa-pie-chart"></i>&nbsp;KnowledgeCafe</a>
    </li>
    @endif


    {{-- @if(auth()->user()->hasAnyPermission(['crm_talent.view', 'crm_client.view']))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="{{ route('crm') }}"><i
        class="fa fa-bar-chart"></i>&nbsp;CRM</a>
    </li>
    @endif --}}

    @if(auth()->user()->can('infrastructure.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('infrastructure.index') }}"><i
                class="fa fa-bar-chart"> </i>&nbsp;Infrastructure</a>
    </li>
    @endif

    @if(auth()->user()->can('clients.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('client.index') }}"><i class="fa fa-bar-chart">
            </i>&nbsp;Clients</a>
    </li>
    @endif

    @if(auth()->user()->can('project.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('project.index') }}"><i class="fa fa-bar-chart">
            </i>&nbsp;Projects</a>
    </li>
    @endif

    @if(auth()->user()->can('task.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="/tasks"><i class="fa fa-bar-chart"> </i>&nbsp;Task</a>
    </li>
    @endif

    @if(auth()->user()->can('legal-document.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('legal-document.index') }}"><i
                class="fa fa-bar-chart"> </i>&nbsp;Legal Documents</a>
    </li>
    @endif

    @if(auth()->user()->can('invoice.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('invoice.index') }}"><i class="fa fa-bar-chart">
            </i>&nbsp;Invoices</a>
    </li>
    @endif


    <li class="nav-item dropdown">
        <a id="navbarDropdown_hr" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            CRM <span class="caret"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown_hr">
            @if(auth()->user()->can('prospect.view'))
            <a class="dropdown-item" href="{{ '/prospect' }}">Prospects</a>
            @endif

            @can('lead.view')
            <a class="dropdown-item" href="{{ '/lead' }}">Leads</a>
            @endcan
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('user.profile') }}"><i class="fa fa-bar-chart">
            </i>&nbsp;My Profile</a>
    </li>


    @if(auth()->user()->can('invoice.view'))
    <li class="nav-item">
        <a class="nav-item nav-link font-weight-bold" href="{{ route('salary.index') }}"><i class="fa fa-bar-chart">
            </i>&nbsp;Salaries</a>
    </li>
    @endif

    @if(auth()->user()->can('invoice.view'))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="{{ route('payment.index') }}"><i class="fa fa-bar-chart">
                </i>&nbsp;Payments</a>
        </li>
    @endif


</ul>