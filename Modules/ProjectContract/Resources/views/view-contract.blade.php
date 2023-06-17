@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>Project Contract - {{$contracts['contract_name']}}</h1>
</div>
<br>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="container">
    <div class="card">
        <div class="card-body text-center">
            <div class="d-flex flex-row mb-3">
                <div class="p-2"><h4>Status :</h4></div>
                <div class="p-2"><h4>{{$contracts['status']}}</h4></div>
            </div>
            <div class="d-flex flex-row mb-3">
                <div class="p-2"><h4>Contract Link :</h4></div>
                <div class="p-2"><h4><a href="{{$contracts['contract_link']}}"><i class="fa fa-link" aria-hidden="true"></i></a></h4></div>
            </div>
            @foreach ($contractsmeta as $contractmeta)        
                <div class="d-flex flex-row mb-3">
                    <div class="p-2"><h4>{{$contractmeta['key']}} :</h4></div>
                    <div class="p-2"><h4>{{$contractmeta['value']}}</h4></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<br>
<div class="container">        
    <div class="form-group">
        <button type="button" class="btn btn-success round-submit" data-toggle="modal" data-target="#reviewformModal"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send for client review</button>

        <!-- Client Review Modal -->
        <div class="modal fade" id="reviewformModal" tabindex="-1" role="dialog" aria-labelledby="reviewformModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewformModalLabel">Reviewer</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary d-none" id="reviewFormSpinner"></div>
                    </div>
                    <div class="review modal-body">
                        <form action="{{ route('projectcontract.sendreview')}}" method="POST" id="recieverForm" >
                            @csrf
                            <input type="hidden" id="id" name="id" value={{$contracts['id']}}>
                            <div class="form-group">
                                <label for="designationfield">Reciever Name</label><strong class="text-danger">*</strong></label>
                                <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="Name" > 
                            </div>
                            <div class='form-group'>
                                <label class="field-required" for="designationfield">Reciever Email</label><br>
                                <input type="text" name="email" class="form-control"  id="email" aria-describedby="Help" placeholder="Email" >
                            </div>   
                            <div class="d-none text-danger" name="error" id="domainerror"></div>   
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submit">Save changes</button>  
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-primary round-submit" data-toggle="modal" data-target="#financeformModal"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send for finance review</button>

        <!-- Finance Review Modal -->
        <div class="modal fade" id="financeformModal" tabindex="-1" role="dialog" aria-labelledby="financeformModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="financeformModalLabel">Finance</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="spinner-border text-primary d-none" id="financeFormSpinner"></div>
                    </div>
                    <div class="finance modal-body">
                        <form action="{{ route('projectcontract.sendfinancereview')}}" method="POST" id="financeForm" >
                            @csrf
                            <input type="hidden" id="id" name="id" value={{$contracts['id']}}>
                            <input type="hidden" id="role" name="role" value="finance">
                            <div class="form-group">
                                <label for="designationfield">Finance Name</label><strong class="text-danger">*</strong></label>
                                <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="Name" > 
                            </div>
                            <div class='form-group'>
                                <label class="field-required" for="designationfield">Finance Email</label><br>
                                <input type="text" name="email" class="form-control"  id="email" aria-describedby="Help" placeholder="Email" >
                            </div>   
                            <div class="d-none text-danger" name="error" id="domainerror"></div>   
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submit">Save changes</button>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<h3>Comments</h3>
<div class="container">
        @foreach ($comments as $comment)
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex flex-row mb-3">
                    <div class="p-2">By: </div>
                    <div class="p-2">
                        @if (str_contains($comment['comment_type'],'Reviewer'))
                            <h4>Client Team</h4>
                        @else
                            <h4>Finance Team</h4>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div class="p-2"><h4>Date :</h4></div>
                    <div class="p-2"><h4>{{$comment['created_at']}}</h4></div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div class="p-2"><h4>Comment: </h4></div>
                    <div class="p-2"><h4>{{$comment['comment']}}</h4></div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
@endsection