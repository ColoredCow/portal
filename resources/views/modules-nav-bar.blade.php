<ul class="navbar-nav mr-auto {{ request()->is('home') ? 'd-none' : '' }}" >
    
    @if(Module::isEnabled('User') && auth()->user()->can('user_management.view'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user.index') }}">User Management</a>
        </li>
    @endif
    
    @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view']))
    <li class="nav-item">
        <li class="nav-item dropdown">
            <a id="navbarDropdown_hr" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                HR <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_hr">
            @can('hr_recruitment_applications.view')
                <a class="dropdown-item" href="{{ route('applications.job.index') }}">Recruitment</a>
            @endcan
            @can('hr_employees.view')
                <a class="dropdown-item" href="{{ route('employees') }}">Employees</a>
            @endcan
            @can('hr_volunteers_applications.view')
                <a class="dropdown-item" href="{{ route('applications.volunteer.index') }}">Volunteers</a>
            @endcan
            </div>
        </li>
    </li>
    @endif
    @can('finance_invoices.view')
        <li class="nav-item">
            <a class="nav-link" href="/finance/reports?type=monthly">Finance</a>
        </li>
    @endcan

    @if(auth()->user()->can('clients.view'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('client.index') }}"></i>Clients</a>
    </li>
    @endif

    @can('projects.view')
        <li class="nav-item">
            <a class="nav-link" href='{{ route('project.index') }}'>Projects</a>
        </li>
    @endcan

    @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
    <li class="nav-item">
        <li class="nav-item dropdown">
            <a id="navbarDropdown_kc" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                KnowledgeCafe <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_kc">
                 @can('library_books.view')
                 <a class="dropdown-item" href="{{ route('books.index') }}">Library</a>
                 @endcan
                 @can('weeklydoses.view')
                 <a class="dropdown-item" href="{{ route('weeklydoses') }}">WeeklyDose</a>
                 @endcan
            </div>
        </li>
    </li>
    @endif
    
    {{-- @if(auth()->user()->hasAnyPermission(['crm_talent.view', 'crm_client.view']))
    <li class="nav-item">
        <li class="nav-item dropdown">
            <a id="navbarDropdown_crm" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                CRM <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_crm">
                 <a class="dropdown-item" href="#">Talent</a>
                 <a class="dropdown-item" href="#">Client</a>
            </div>
        </li>
    </li>
    @endif --}}

    @if(auth()->user()->can('infrastructure.view'))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('infrastructure.index') }}">&nbsp;Infrastructure</a>
        </li>
    @endif

  

</ul>