@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
    @include('infrastructure::menu_header', ['tab' => 'EC2 Instances'])

    <table class="table table-bordered table-striped my-6">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Instance</th>
            <th scope="col">Type</th>
            <th scope="col">Launch time</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($instances as $instance)
                <tr>
                    <td>
                        <div>{{ $instance['name'] }}</div>
                        <div>
                            @if ($instance['state'] == 'running')
                                <div class="badge badge-success badge-pill">
                                    <i class="fa fa-check-circle fz-12"></i>
                                    <span>{{ $instance['state'] }}</span>
                                </div>
                            @else
                                <div class="badge badge-danger badge-pill">{{ $instance['state'] }}</div>
                            @endif
                        </div>
                    </td>
                    <td>{{ $instance['type'] }}</td>
                    <td>{{ $instance['launch_time'] }}</td>
                    <td>
                        <a href="{{ $instance['console_url'] }}" target="_blank">
                            <span>View instance</span>
                            <span><i class="fa fa-external-link fz-14"></i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
