@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Command Name</th>
            <th scope="col">Command Description</th>
            <th scope="col">Next Refresh Time</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td>{{ $event->command }}</td>
                <td>{{ $event->next_run_at }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
</div>

@endsection