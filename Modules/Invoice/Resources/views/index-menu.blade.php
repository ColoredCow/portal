<ul class="nav nav-pills my-3">
    <li class="nav-item mr-3">
        <a class="nav-link {{ (request()->input('status', 'sent') == 'sent') ? 'active' : '' }}"
            href="{{ route('invoice.index', ['status' => 'sent'])  }}">Sent Invoices</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ (request()->input('status', 'sent') == 'paid') ? 'active' : '' }}"
            href="{{ route('invoice.index', ['status' => 'paid'])  }}">Paid Invoices</a>
    </li>
</ul>