<ul class="navbar-nav mr-auto" style="font-size:16px;">
    @canany(['hr_recruitment_applications.view', 'hr_employees.view', 'hr_volunteers_applications.view',
        'hr_settings.view', 'hr_universities.view'])
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>HR <span class="caret"></span>
            </a>
            <div class="dropdown-menu z-index-1100" aria-labelledby="navbarDropdown_sales">
                @can('hr_recruitment_applications.view')
                    <a class="dropdown-item" href="{{ route('applications.job.index') }}">Recruitment</a>
                @endcan
                @can('hr_employees.view')
                @php
                    $params = array_merge(['name' => 'Employee'], ['status' => 'current']);
                @endphp
                    <a class="dropdown-item" href="{{ route('employees',$params) }}">Working Staff</a>
                @endcan
                    <a class="dropdown-item" href="{{ route('requisition') }}">Resource Requisition</a>
                    <a class="dropdown-item" href="{{ route('designation') }}">Designations</a>
                @can('hr_volunteers_applications.view')
                    <a class="dropdown-item" href="{{ route('applications.volunteer.index') }}">Volunteers</a>
                @endcan
                @can('hr_recruitment_applications.view')
                    <a class="dropdown-item" href="{{ route('hr.evaluation') }}">Manage Evaluation</a>
                @endcan
                @can('hr_settings.view')
                    <a class="dropdown-item" href="{{ route('settings.hr') }}">Settings</a>
                @endcan
                @can('hr_universities.view')
                    <a class="dropdown-item" href="{{ route('universities.index') }}">Universities</a>
                @endcan
                @can('hr_recruitment_applications.view')
                    <a class="dropdown-item" href="{{ route('userappointmentslots.show', auth()->id()) }}">Appointment Slots</a>
                @endcan
                @can('hr_settings.view')
                    <a class="dropdown-item" href="{{ route('hr.tags.index') }}">{{ __('Manage Tags') }}</a>
                @endcan
                @can('hr_recruitment_applications.view')
                    <a class="dropdown-item" href="{{ route('resources.index') }}">Guidelines And Resources</a>
                @endcan
            </div>
        </li>
    @endif

    @if ((Module::checkStatus('Client') &&
        auth()->user()->can('clients.view')) ||
        (Module::checkStatus('Project') &&
            auth()->user()->can('projects.view')))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_pm" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>CRM<span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_finance">
                @can('clients.view')
                    <a class="dropdown-item" href="{{ route('client.index') }}">Clients</a>
                @endcan
                @can('projects.view')
                    <a class="dropdown-item" href="{{ route('project.index') }}">Projects</a>
                @endcan
                @can('projectscontract.view')
                    <a class="dropdown-item" href="{{ route('projectcontract.index') }}">Project Contract</a>
                @endcan
            </div>
        </li>
    @endif

    @can('task.view')
        <li class="nav-item">
            <a class="nav-item nav-link" href="/task">Task</a>
        </li>
    @endcan

    @can('finance_invoices.view')
        <li class="nav-item dropdown">
            <a id="navbarDropdown_finance" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Finance <span class="caret"></span>
            </a>
            <div class="dropdown-menu z-index-1100" aria-labelledby="navbarDropdown_finance">
                <a class="dropdown-item" href="{{ route('revenue.proceeds.index') }}">Revenue</a>
                <a class="dropdown-item" href="{{ route('expense.index') }}">Expenses</a>
                <a class="dropdown-item" href="{{ route('reports.finance.dashboard') }}">Reports</a>
                <a class="dropdown-item" href="{{ route('invoice.index') }}">Invoices</a>
                <a class="dropdown-item" href="{{ route('ledger-accounts.index') }}">Ledger Accounts</a>
                <a class="dropdown-item disabled" href="{{ route('salary.index') }}">Salaries</a>
                <a class="dropdown-item disabled" href="{{ route('payment.index') }}">Payments</a>
                <a class="dropdown-item disabled" href="{{ route('legal-document.index') }}">Legal Documents</a>
            </div>
        </li>
    @endcan

    @canany(['prospect.view', 'lead.view', 'sales_automation.view', 'sales_reports.view'])
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Sales <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_sales">
                @can('prospect.view')
                    <a class="dropdown-item" href="{{ '/prospect' }}">Prospects</a>
                @endcan
                @can('lead.view')
                    <a class="dropdown-item" href="{{ '/lead' }}">Leads</a>
                @endcan
                @can('sales_automation.view')
                    <a class="dropdown-item" href="{{ route('salesautomation.index') }}">Sales Automation</a>
                @endcan
                @can('sales_reports.view')
                    <a class="dropdown-item" href="{{ '/report' }}">Report</a>
                @endcan
            </div>
        </li>
    @endcan

    @if (auth()->user()->canAny(['weeklydoses.view', 'library_books.view']))
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>KnowledgeCafe <span
                    class="caret"></span>
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

    @can('infrastructure.billings.view')
        <li class="nav-item dropdown">
            <a id="navbarDropdown_sales" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Infrastructure<span
                    class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown_sales">
                @can('infrastructure.ec2-instances.view')
                    <a class="dropdown-item" href="{{ route('infrastructure.ec2-instances.index') }}">EC2 Instances</a>
                @endcan
                @can('infrastructure.backups.view')
                    <a class="dropdown-item" href="{{ route('infrastructure.s3-buckets.index') }}">Backups</a>
                @endcan
            </div>
        </li>
    @endcan

    @can('media.view')
        <li class="nav-item">
            <a class="nav-item nav-link" href="{{ route('media.index') }}">Media</a>
        </li>
    @endcan

    @canany(['hr_settings.view', 'user_management.view', 'finance_invoices_settings.view', 'nda_settings.view'])
        <li class="nav-item dropdown">
            <a id="navbarDropdown_settings" class="nav-link dropdown-toggle" href="#" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Settings<span
                    class="caret"></span>
            </a>
            <div id="dropdownMenu_settings" class="dropdown-menu" aria-labelledby="navbarDropdown_settings">
                @canany(['hr_settings.view', 'finance_invoices_settings.view', 'nda_settings.view'])
                    <a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a>
                @endcanany
                @can('user_management.view')
                    <a class="dropdown-item" href="{{ route('user.index') }}">User Management</a>
                @endcan
            </div>
        </li>
    @endcanany
</ul>
