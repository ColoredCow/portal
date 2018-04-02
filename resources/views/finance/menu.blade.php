<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'clients' ? 'active' : '' }}" href="/clients">Clients</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'projects' ? 'active' : '' }}" href="/projects">Projects</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ $active === 'invoices' ? 'active' : '' }}" href="/finance/invoices">Invoices</a>
    </li>
</ul>
