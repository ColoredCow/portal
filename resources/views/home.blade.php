@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Hello {{ $user->name }}, you're logged in!<br><br>
                    @if(sizeof($groups))
                    Here are your groups:
                    <ol>
                        @foreach($groups as $groupEmail => $groupName)
                        <li>{{ $groupName }}</li>
                        @endforeach
                    </ol>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}
    <br>
    <div class="row">
        <div class="offset-md-1 col-md-3 card">
            <a class="card-body no-transition" href="/hr/applicants/">
                <br>
                <h2 class="text-center">HR</h2>
                <br>
            </div>
        </div>
    </div>
</div>
@endsection
