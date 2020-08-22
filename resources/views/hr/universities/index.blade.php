@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    @include('hr.universities.menu')
    <br><br>
    <div class="row">
        <div class="col-md-6"><h1>Universities</h1></div>
        <div class="col-md-2">
            <a href="{{ route('universities.create') }}" class="btn btn-success float-right">Add University</a>
        </div>
        <div class="col-md-4">
            <form class="d-flex justify-content-end align-items-center"  method="GET" action="/{{ Request::path() }}">
                <input type="hidden" name="status" class="form-control" id="search" value="">
                <input type="text" name="search" class="form-control" id="search" placeholder="Search university">
                <button class="btn btn-info ml-2">Search</button>
            </form>
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
            <tr>
                <th>University</th>
                <th>Contact Details</th>
                <th>Action</th>
            </tr>
            @foreach($universities as $university)
            <tr>
            <td>
            <h5 style="font-weight:bold">{{$university->name}}</h5>
            {{$university->address}}
            </td>
            <td>
            <table class="table table-borderless table-nostriped" id="contacts_table{{$university->id}}">
            
                @foreach($university->universityContacts as $contact)
                <tr>
                    <td>
                    {{$contact->name}}
                    </td>
                    <td>
                    {{$contact->email}}
                    </td>
                    <td>
                    {{$contact->designation}}
                    </td>
                    <td>
                    {{$contact->phone}}
                    </td>
                </tr>
                @endforeach
            </table>
            </td>
            <td>
            <div class="d-flex justify-content-around">   
                        <a href="{{ route('universities.edit',$university->id) }}" class="mr-1 btn btn-link"><i style="color:green" class="fa fa-edit fa-lg"></i></a>
                        
                        <form  action="{{ route('universities.destroy',$university->id) }}" class="myformDelete" method="POST" id="form_delete_universities_contacts{{$university->id}}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link"><i style="color:red" class="fa fa-trash fa-lg"></i></button>
                        </form>
                <div>  
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    {{ $universities->links() }}
</div>
@endsection
