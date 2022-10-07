@extends('hr::layouts.master')
@section('content')
<div class="container">
    <br>
    @include('hr::universities.menu')
    <br><br>
    <div class="row">
        <div class="col-md-5">
            <h1>Universities</h1>
        </div>
        <div class="col-md-4">
            <form class="d-flex" method="GET" action="/{{ Request::path() }}">
                <input type="hidden" name="status" class="form-control" id="search" value="">
                <input type="text" name="search" class="form-control" id="search" placeholder="Search university">
                <button class="btn btn-info ml-1">Search</button>
            </form>
        </div>
        <div class="col-md-3">
            <a href="{{ route('universities.create') }}" class="btn btn-success btn-block btn-lg"><i class="fa fa-plus mr-1"></i> Add New University</a>
        </div>
    </div>
    @include('status', ['errors' => $errors->all()])
    @if(request()->has('search'))
    <div class="row mt-3 mb-2">
        <div class="col-6">
            <a class="text-muted c-pointer" href="/{{ Request::path() }}?status={{request('status')}}">
                <i class="fa fa-times"></i>&nbsp;Clear current search and filters
            </a>
        </div>
    </div>
    @endif
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="universities_table">
            <thead class="thead-dark">
            <tr>
                <th>University</th>
                <th>Contact Details</th>
                <th>Actions</th>
            </tr>
            @foreach($universities as $university)
            <tr>
                <td>
                    <a href="{{ route('universities.edit',$university) }}" class="font-weight-bold text-primary">{{$university->name}}</a>
                    <div class="mb-2 fz-xl-14 text-secondary d-flex flex-column">
                        <span class="mr-1"><i class="fa fa-address-card mr-1"></i>{{$university->address}}</span>
                    </div>
                </td>
                <td>
                    <div class="row">
                    @foreach($university->universityContacts as $contact)
                        <div class="col-6 mb-1">
                            <span class=" text-dark">{{$contact->name}}</span>
                            <div class="mb-2 fz-xl-14 text-secondary d-flex flex-column">
                                <span class="mr-1 text-truncate"><i class="fa fa-envelope-o mr-1"></i>{{$contact->email}}</span>
                                <span class="mr-1"><i class="fa fa-phone mr-1"></i>{{$contact->phone}}</span>
                                <span class="mr-1"><i class="fa fa-briefcase mr-1"></i>{{$contact->designation}}</span>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </td>
                <td>
                    <form class="d-flex" action="{{ route('universities.destroy',$university) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('universities.edit',$university) }}" title="Edit" class="pr-1 btn btn-link"><i class="text-success fa fa-edit fa-lg"></i></a>
                        <button type="submit" class="pl-1 btn btn-link" title="Delete"><i class="text-danger fa fa-trash fa-lg"></i></button>
                    </form>
                </td>
            </tr>
        
            @endforeach
        </table>
    </div>
    {{ $universities->links() }}
</div>
@endsection