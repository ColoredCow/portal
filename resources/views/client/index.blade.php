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
            <th>Phone</th>
            <th>Status</th>
            <th>Projects</th>
        </tr>
        @foreach ($clients as $client)
        	<tr>
        		<td>
        			<a href="/clients/{{ $client->id }}/edit/">{{ $client->name }}</a>
        		</td>
        		<td>
        			<span>{{ $client->phone ?? '-' }}</span>
        		</td>
                <td>
                @switch ($client->is_active)
                    @case(true)
                        <span class="badge badge-pill badge-success">active</span>
                        @break
                    @case(false)
                        <span class="badge badge-pill badge-danger">inactive</span>
                        @break
                @endswitch
                </td>
                <td>
                @if ($client->projects->count())
                   <a href="{{ route('projects.index') }}?client_id={{$client->id }}">See Projects</a>
                @else
                   -
                @endif
                </td>
        	</tr>
        @endforeach
    </table>
    {{ $clients->links() }}
</div>
@endsection
