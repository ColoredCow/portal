@extends('user::layouts.master')
@section('content')

<div class="container">
    <br>
    <br>
    <br>
    @include('user::profile.subviews.show-header', ['section' => $section])
    <br>

    <div class="card">
        <div class="card-body">
            @includeWhen($section == 'basic-details', 'user::profile.show-basic-details')
            @includeWhen($section == 'documents', 'user::profile.show-documents')
            @includeWhen($section == 'finance', 'user::profile.show-finance-details')
        </div>
    </div>

</div>
@endsection