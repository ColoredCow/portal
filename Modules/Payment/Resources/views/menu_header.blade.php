<ul class="nav nav-pills my-3">
    @php
        $request = request()->all();
    @endphp
    <li class="nav-item mr-3">
        
        <a class= "nav-link" href="{{ route('transaction-index.expense',$request)  }}">Expense</a>
    </li>

    <li class="nav-item">
        <a class= "nav-link" href="{{ route('transaction-index.revenue',$request)  }}">Revenue</a>
    </li>
</ul>