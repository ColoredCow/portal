@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('finance.menu', ['active' => 'clients'])
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Clients</h1></div>
        <div class="col-md-6"><a href="/clients/create" class="btn btn-success float-right">Create Client</a></div>
    </div>
    <table class="table table-striped table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
        @foreach ($clients as $client)
        	<tr>
        		<td>
        			<a href="/clients/{{ $client->id }}/edit/">{{ $client->name }}</a>
        		</td>
        		<td>{{ $client->email ?? '-' }}</td>
        		<td>
        			<span>{{ $client->phone ?? '-' }}</span>
        		</td>
        	</tr>
        @endforeach
    </table>
    {{ $clients->links() }}
</div>
@endsection
