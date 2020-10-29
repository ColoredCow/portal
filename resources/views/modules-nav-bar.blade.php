<ul class="navbar-nav mr-auto {{ request()->is('home') ? 'd-none' : '' }}" style="font-size:16px;">

    @if(Module::checkStatus('User') && auth()->user()->can('user_management.view'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.index') }}">User Management</a>
    </li>
    @endif

    @if(auth()->user()->hasAnyPermission(['hr_recruitment_applications.view', 'hr_employees.view',
    'hr_volunteers_applications.view','hr_universities.view']))
    <li class="nav-item">
    <li class="nav-item dropdown">
        <a id="navbarDropdown_hr" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
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
            @can('hr_recruitment_applications.view')
            <a class="dropdown-item" href="{{ route('hr.evaluation') }}">Manage Evaluation</a>
            @endcan
            @can('hr_recruitment_applications.view')
            <a class="dropdown-item" href="{{ route('settings.hr') }}">Settings</a>
            @endcan
            @can('hr_universities.view')
                <a class="dropdown-item" href="{{ route('universities.index') }}">Universities</a>
            @endcan
            <a class="dropdown-item" href="{{route('userappointmentslots.show',auth()->id())}}">Appointment Slots</a>
        </div>
    </li>
    </li>
    @endif
    {{-- @can('finance_invoices.view')
        <li class="nav-item">
            <a class="nav-link" href="/finance/reports?type=monthly">Finance</a>
        </li>
    @endcan --}}

    @if(Module::checkStatus('Client') && auth()->user()->can('clients.view'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('client.index') }}"></i>Clients</a>
    </li>
    @endif

    @if(Module::checkStatus('Project') && auth()->user()->can('projects.view'))
    <li class="nav-item">
        <a class="nav-link" href='{{ route('project.index') }}'>Projects</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href='{{ route('task.index') }}'>Project Tasks</a>
    </li>

    @endif

    @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
    <li class="nav-item">
    <li class="nav-item dropdown">
        <a id="navbarDropdown_kc" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
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

    @if(Module::checkStatus('Prospect') || Module::checkStatus('Lead'))
    <li class="nav-item dropdown">
        <a id="navbarDropdown_hr" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
            CRM <span class="caret"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown_hr">
            @if(Module::checkStatus('Prospect') && auth()->user()->can('prospect.view'))
            <a class="dropdown-item" href="{{ '/prospect' }}">Prospects</a>
            @endif

            @if(Module::checkStatus('Lead') && auth()->user()->can('lead.view'))
            <a class="dropdown-item" href="{{ '/lead' }}">Leads</a>
            @endif
        </div>
    </li>
    @endif

    @if(Module::checkStatus('Infrastructure') && auth()->user()->can('infrastructure.view'))
    <li class="nav-item">
        <a class="nav-link" href="{{ route('infrastructure.index') }}">&nbsp;Infrastructure</a>
    </li>
    @endif

</ul>
