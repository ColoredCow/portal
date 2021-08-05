<ul class="nav nav-pills fz-16">
    @if(Module::checkStatus('HR'))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>HR <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_sales">
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
    @endif

    @if(auth()->user()->hasAnyPermission(['weeklydoses.view', 'library_books.view']))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>KnowledgeCafe <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_sales">
                @can('library_books.view')
                    <a class="dropdown-item" href="{{ route('books.index') }}">Library</a>
                @endcan
                @can('weeklydoses.view')
                    <a class="dropdown-item" href="{{ route('weeklydoses') }}">WeeklyDose</a>
                @endcan
            </div>
        </li>
    @endif

    @if(Module::checkStatus('Client') || Module::checkStatus('Project'))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_pm" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Project Management <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_finance">
                @if(Module::checkStatus('Client') && auth()->user()->can('clients.view'))
                    <a class="dropdown-item" href="{{ route('client.index') }}">Clients</a>
                @endif
                @if(Module::checkStatus('Project') && auth()->user()->can('project.view'))
                    <a class="dropdown-item" href="{{ route('project.index') }}">Projects</a>
                @endif
            </div>
        </li>
    @endif

    @if(Module::checkStatus('Task') && auth()->user()->can('task.view'))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="/task"><i class="fa fa-bar-chart"></i>&nbsp;Task</a>
        </li>
    @endif

    @if(Module::checkStatus('Invoice') || Module::checkStatus('LegalDocument'))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_finance" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Finance <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_finance">
                @if(Module::checkStatus('Invoice') && auth()->user()->can('invoice.view'))
                    <a class="dropdown-item" href="{{ route('invoice.index') }}">Invoices</a>
                    <a class="dropdown-item" href="{{ route('invoice.tax-report') }}">Monthly tax report</a>
                    <a class="dropdown-item disabled" href="{{ route('salary.index') }}">Salaries</a>
                    <a class="dropdown-item disabled" href="{{ route('payment.index') }}">Payments</a>
                @endif
                @if(Module::checkStatus('LegalDocument') && auth()->user()->can('legal-document.view'))
                <a class="dropdown-item disabled" href="{{ route('legal-document.index') }}">Legal Documents</a>
                @endif
            </div>
        </li>
    @endif

    @if(Module::checkStatus('Prospect') || Module::checkStatus('Lead') || Module::checkStatus('SalesAutomation'))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Sales <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_sales">
                @if(Module::checkStatus('Prospect') && auth()->user()->can('prospect.view'))
                    <a class="dropdown-item" href="{{ '/prospect' }}">Prospects</a>
                @endif
                @if(Module::checkStatus('Lead') && auth()->user()->can('lead.view'))
                    <a class="dropdown-item" href="{{ '/lead' }}">Leads</a>
                @endif
                @if(Module::checkStatus('SalesAutomation'))
                    <a class="dropdown-item" href="{{ '/lead' }}">Sales Automation</a>
                @endif
            </div>
        </li>
    @endif

    @if(Module::checkStatus('Infrastructure') && auth()->user()->can('infrastructure.view'))
        <li class="nav-item">
            <a class="nav-item nav-link font-weight-bold" href="{{ route('infrastructure.index') }}"><i class="fa fa-bar-chart"> </i>&nbsp;Infrastructure</a>
        </li>
    @endif

    @if(Module::checkStatus('HR') || Module::checkStatus('User'))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_settings" class="nav-link dropdown-toggle font-weight-bold" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fa fa-cog"></i> Settings<span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_settings">
                @if(Module::checkStatus('HR') && auth()->user()->can('hr_recruitment_applications.view'))
                    <a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a>
                @endif
                @if(Module::checkStatus('User') && auth()->user()->can('user_management.view'))
                    <a class="dropdown-item" href="{{ route('user.index') }}">User Management</a>
                @endif
            </div>
        </li>
    @endif
</ul>
