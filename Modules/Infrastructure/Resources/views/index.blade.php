@extends('infrastructure::layouts.master')

@section('content')
<div class="container">
    @include('infrastructure::menu_header', ['tab' => 'Database Backups'])

    <table class="table table-bordered table-striped my-6">
        <thead class="thead-dark">
          <tr>
            <th scope="col">S3 Bucket</th>
            <th scope="col">Created time</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
            @foreach($storageBuckets as $storageBucket)
                <tr>
                    <td>{{ $storageBucket['name'] }}</td>
                    <td>{{ $storageBucket['created_at'] }}</td>
                    <td>
                        <a href="{{ $storageBucket['console_url'] }}" target="_blank">
                            <span>View bucket</span>
                            <span><i class="fa fa-external-link"></i></span>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
