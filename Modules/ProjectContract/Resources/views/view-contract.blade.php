@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center">
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
            <div class="container">
                @if ($user->status == 'approved')
                    <span class="badge badge-success badge-pill mr-1 mb-1 fz-12">CC Team: {{$user->status}}</span>
                @else
                    <span class="badge badge-warning badge-pill mr-1 mb-1 fz-12">CC Team: {{$user->status}}</span>
                @endif

                @if ($client)
                    @if ($client->status == 'approved')
                        <span class="badge badge-success badge-pill mr-1 mb-1 fz-12">Client - {{$client->status}}</span>
                    @else
                        <span class="badge badge-warning badge-pill mr-1 mb-1 fz-12">Client - {{$client->status}}</span>
                    @endif
                @endif

                @if ($finance)
                    @if ($finance->status == 'approved')
                        <span class="badge badge-success badge-pill mr-1 mb-1 fz-12">Finance Team - {{$finance->status}}</span>
                    @else
                        <span class="badge badge-warning badge-pill mr-1 mb-1 fz-12">Finance Team - {{$finance->status}}</span>
                    @endif
                @endif
            </div>
            <div class="d-flex flex-row-reverse">
                @if ($user and $client and $finance and $user->status == 'approved' and $client->status == 'approved' and $finance->status == 'approved')
                    <a class="btn btn-success"><i class="fa fa-file-pdf-o mr-1" ></i>Generate Contract</a>
                @else    
                    <a class="btn btn-success" href="{{route('projectcontract.edit', $contracts['id'])}}"><i class="fa fa-edit mr-1" ></i>Edit & Approve</a>
                @endif
            </div>
            <div class="container">
                <h3 class="row p-1">Contract Status</h3>
                <div>
                    <div class="d-flex flex-row">
                        <p class='px-1'><strong>Status:</strong></p>
                        <p>{{$contracts['status']}}</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container">
                @foreach($contractsmeta as $group => $metadata)
                    <h3 class="row p-1">{{ config('projectcontract.contract.group.' . $group) }}</h3>
                    <div>
                        @foreach($metadata as $item)
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row">
                                    <p class='px-1'><strong>{{ config('projectcontract.contract.key.' . $item->key) }}:</strong></p>
                                    @if ($group == 'project-summary') 
                                    <div class="col-sm-9 overflow-auto" style="max-height: 300px;">
                                        <p class="text-left" style="white-space: pre-wrap;">{{ $item->value }}</p>
                                    </div>
                                    @else
                                        <p>{{ $item->value }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="form-group">
        @if ($user->status == "pending")
            <a class="btn btn-success" href="{{route('projectcontract.internal-response', $contracts['id'])}}"><i class="fa fa-check mr-1" ></i>Approve</a>
        @else
            <a class="btn btn-success" disabled><i class="fa fa-check mr-1" ></i>approved</a>
        @endif

        @if (!$client)
        <button type="button" class="btn btn-primary round-submit" data-toggle="modal" data-target="#reviewformModal"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send for client review</button>
        @else
        <button type="button" class="btn btn-primary round-submit"><i class="fa fa-paper-plane" aria-hidden="true"></i> Already sent for client review</button>
        @endif

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
                        <form action="{{ route('projectcontract.send-review')}}" method="POST" id="recieverForm" >
                            @csrf
                            <input type="hidden" id="id" name="id" value={{$contracts['id']}}>
                            <div class="form-group">
                                <label for="designationfield">Receiver Name</label><strong class="text-danger">*</strong></label>
                                <input type="text" name="name" class="form-control"  id="name" aria-describedby="Help" placeholder="Name" > 
                            </div>
                            <div class='form-group'>
                                <label class="field-required" for="designationfield">Receiver Email</label><br>
                                <input type="text" name="email" class="form-control"  id="email" aria-describedby="Help" placeholder="Email" >
                            </div>   
                            <div class="d-none text-danger" name="error" id="domainerror"></div>   
                            <button type="submit" class="btn btn-primary" id="submit">Save changes</button>  
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (!$finance)
        <button type="button" class="btn btn-secondary round-submit" data-toggle="modal" data-target="#financeformModal"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send for finance review</button>
        @else
        <button type="button" class="btn btn-secondary round-submit" disabled></i> Already sent for finance review</button>
        @endif
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
                        <form action="{{ route('projectcontract.send-finance-review')}}" method="POST" id="financeForm" >
                            @csrf
                            <input type="hidden" id="id" name="id" value={{$contracts['id']}}>
                            <input type="hidden" id="role" name="role" value="finance">
                            <div class="form-group">
                                <label for="designationfield">Finance Email</label><strong class="text-danger">*</strong></label>
                                <select type="text" name="email" id="email" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{$user->email}}">{{$user->email}}</option>
                                @endforeach
                                </select>
                            </div>  
                            <div class="d-none text-danger" name="error" id="domainerror"></div>   
                            <button type="submit" class="btn btn-primary" id="submit">Save changes</button>  
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($comments)
<div class="container">
        <h3>Comments</h3>
        @foreach ($comments as $comment)
        <div class="card">
            <div class="card-body text-center">
                <div class="d-flex flex-row-reverse">
                    <a href="{{ route('projectcontract.comment-history',$comment['id'])}}" target="_blank"><i class="fa fa-history"></i> View History</a>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div>By: </div>
                    <div>
                        @if (str_contains($comment['comment_type'],'Reviewer'))
                            <h4>Client Team</h4>
                        @else
                            <h4>Internal Team</h4>
                        @endif
                    </div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div><h4>Date: </h4></div>
                    <div><h4>{{$comment['created_at']}}</h4></div>
                </div>
                <div class="d-flex flex-row mb-3">
                    <div><h4>Comment: </h4></div>
                    <div><h4>{{$comment['comment']}}</h4></div>
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
@endif
@endsection