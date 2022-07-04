@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Cron Jobs List</h2>
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
  @endif
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Command Name</th>
            <th scope="col">Command Description</th>
            <th scope="col">Next Run Time</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
            <tr>
                <td width="25p">{{ $event->command }}</td>
                <td width="25p">{{ $event->description }}</td>
                <td width="25p">{{ $event->next_run_at }}</td>
                <td width="25p">
                  <a href="{{ route('settings.cron.run', ['command' => $event->command]) }}">
                    <button type="button" class="btn btn-primary">Run now</button>
                  </a>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
</div>

@endsection
