@extends('project::layouts.master')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Project Resource</h1>
        </div>

        <br>

        <h3 class="font-weight-bold">
            Additional Resources Required in all Projects : {{ $resourceData['totalCount'] }}
        </h3>

        <br>

        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th class="w-30p sticky-top">Client/Project Name</th>
                        <th class="w-20p sticky-top">Resouce Needed</th>
                        <th class="w-20p sticky-top">Resource Deployed</th>
                        <th class="w-20p sticky-top">Additional Resource Required</th>
                        <th class="w-20p sticky-top">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @can('projects.view')
                        @foreach ($resourceData['data'] as $clientName =>$clientProjectsData)
                            <tr class="bg-theme-warning-lighter">
                                <td colspan="5" class="font-weight-bold">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            {{ $clientName }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($clientProjectsData as $projectName => $projectData)
                            <tr>
                                <td class="w-33p">
                                    <div class="pl-1 pl-xl-2">
                                        {{ $projectName }}
                                    </div>
                                </td>
                                <td> 
                                    @foreach ($projectData['teamMemberNeededByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach 
                                </td>
                                <td> 
                                    @foreach ($projectData['currentTeamMemberCountByDesignation'] as $designationName => $count)
                                        <div> {{ $designationName }} : {{ $count }} </div>
                                    @endforeach
                                </td>  
                                <td> 
                                    <div class="d-flex justify-content-center"> {{ $projectData['additionalResourceRequired'] }} </div>
                                </td> 
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <div><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#requisitionModal"><i class="fa fa-plus mr-1"></i>Add Requisition</button></div>
                                    </div>
                                    <div class="d-none alert alert-success " id="successMessage" role="alert">
                                        <strong>Requisition</strong> Submitted successfully!
                                        <button type="button" class="close" id="closeSuccessMessage" aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal fade" id="requisitionModal" tabindex="-1" role="dialog" aria-labelledby="requisition" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="requisition">Add Job Requisition</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <div class="spinner-border text-primary d-none" id="formSpinner"></div>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="requisitionForm" action="{{ route('requisition.store') }}" method="post">
                                                        @csrf
                                                        <div>
                                                            <label for="domainDropdown">Select Domain</label>
                                                            <select class="form-control" name="domain" id="domain"> 
                                                                @foreach ($domainName as $domain)
                                                                <option value="{{ $domain->id }}">{{ $domain->domain }}</option>
                                                                @endforeach 
                                                            </select><br>
                                                        </div>
                                                        <div>
                                                            <label for="jobDropdown">Select Job</label>
                                                            <select class="form-control" name="job" id="job"> 
                                                                @foreach ($jobName as $job)
                                                                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                                                                @endforeach 
                                                            </select><br>
                                                        </div><br>
                                                        <input type="hidden" name="user" id="user" value={{ auth()->user()->id }}>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" data-action="sendHiringMail">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endforeach
                    @endcan  
                </tbody>
            </table>
        </div>
    </div>    
@endsection

        