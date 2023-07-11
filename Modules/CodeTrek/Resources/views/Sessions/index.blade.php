@extends('codetrek::layouts.master')
@section('heading', 'CodeTrek')
@section('content')
    <div class="container" id="applicant">
        @includeWhen(session('success'), 'toast', ['message' => session('success')])
        <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
            <div>
                <h1>Sessions</h1>
            </div>

            <div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createSessionModal">
                    + Add new session
                </button>

                <!-- Modal -->
                <div class="modal fade" id="createSessionModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add new session</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary d-none " id="sessionFormSpinner"></div>
                            </div>
                            <form action="{{ route('codetrek.session.store') }}" method="post" id="sessionForm">
                                @csrf
                                <input type="hidden" name="applicant_id" value="{{ $codeTrekApplicant->id }}">
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="topic_name" class="field-required">Session Name</label>
                                            <input type="text" class="form-control" name="topic_name" id="topicName"
                                                placeholder="Enter topic name" required="required" value="">
                                            <div class="text-danger d-none" id="sessionTopicNameError"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="link" class="field-required">Session Link</label>
                                            <input type="text" class="form-control" name="link" id="topicLink"
                                                placeholder="Enter session link" required="required" value="">
                                            <div class="text-danger d-none" id="sessionLinkError"></div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="date" class="field-required">Date</label>
                                            <input type="date" class="form-control" name="date" id="date"
                                                placeholder="Enter date" required="required" value="">
                                            <div class="text-danger d-none" id="sessionDateError"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="level" class="field-required">Level</label>
                                            <select name="level" id="levelId" class="form-control" required>
                                                <option value="">Level at Session</option>
                                                <option value="1">level 1</option>
                                                <option value="2">level 2</option>
                                                <option value="3">level3</option>
                                            </select>
                                            <div class="text-danger d-none" id="sessionLevelError">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="summary" class="field-required">Summary</label>
                                            <textarea class="form-control" name="summary" id="summary" placeholder="Enter session summary" required="required"
                                                rows="4"></textarea>
                                            <div class="text-danger d-none" id="sessionSummaryError"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <br>
        <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
            <h3> Name : {{ $codeTrekApplicant->first_name . ' ' . $codeTrekApplicant->last_name }}</h3>
        </div>
        <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
            <h5>📩 {{ $codeTrekApplicant->email }}</h5>
        </div>
        <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
            <h5>🏫 {{ $codeTrekApplicant->university }}</h5>
        </div>
        <br>
        <br>
        <div>
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr class="text-center sticky-top">
                        <th class="col-md-2">Tpoic Name</th>
                        <th class="col-md-2">Date</th>
                        <th class="col-md-2">Level</th>
                        <th class="col-md-4">Summary</th>
                        <th class="col-md-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessions as $session)
                        <tr>
                            <td>
                                <h4 class="">
                                    <a href="{{ $session->link }}">{{ $session->topic_name }}</a>
                                </h4>
                            </td>
                            <td>
                                <h4>{{ $session->date }}</h4>
                            </td>
                            <td>
                                <h4>level-{{ $session->level }}</h4>
                            </td>
                            <td>
                                <h4>{{ $session->summary }}</h4>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-item-center">
                                    <button type="button" class="p-0 mr-5 pt-0.5  btn btn-link" data-toggle="modal"
                                        data-target="#editSessionModal{{ $session->id }}">
                                        <i class="text-success fa fa-edit fa-lg"></i>
                                    </button>
                                    <div class="modal fade" id="editSessionModal{{ $session->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit session</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <div class="spinner-border text-primary d-none "
                                                        id="sessionFormSpinner"></div>
                                                </div>
                                                <form action="{{ route('codetrek.session.update', $session->id) }}"
                                                    method="post" id="editSessionForm">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="applicant"
                                                        value="{{ $codeTrekApplicant->id }}">
                                                    <div class="modal-body">
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="topic_name" class="field-required">Session
                                                                    Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="topic_name" id="topicName"
                                                                    placeholder="Enter topic name" required="required"
                                                                    value="{{ $session->topic_name }}">
                                                                <div class="text-danger d-none"
                                                                    id="sessionTopicNameError">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="link" class="field-required">Session
                                                                    Link</label>
                                                                <input type="text" class="form-control" name="link"
                                                                    id="topicLink" placeholder="Enter session link"
                                                                    required="required" value="{{ $session->link }}">
                                                                <div class="text-danger d-none" id="sessionLinkError">
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-6">
                                                                <label for="date" class="field-required">Date</label>
                                                                <input type="date" class="form-control" name="date"
                                                                    id="date" placeholder="Enter date"
                                                                    required="required" value="{{ $session->date }}">
                                                                <div class="text-danger d-none" id="sessionDateError">
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="level" class="field-required">Level</label>
                                                                <select name="level" id="levelId"
                                                                    class="form-control" required>
                                                                    <option value="">Level at Session</option>
                                                                    <option value="1"
                                                                        {{ $session->level == 1 ? 'selected' : '' }}>level
                                                                        1</option>
                                                                    <option value="2"
                                                                        {{ $session->level == 2 ? 'selected' : '' }}>level
                                                                        2</option>
                                                                    <option value="3"
                                                                        {{ $session->level == 3 ? 'selected' : '' }}>level3
                                                                    </option>
                                                                </select>
                                                                <div class="text-danger d-none" id="sessionLevelError">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="form-group col-md-12">
                                                                <label for="summary"
                                                                    class="field-required">Summary</label>
                                                                <textarea class="form-control" name="summary" id="summary" placeholder="Enter session summary"
                                                                    required="required" rows="4"></textarea>
                                                                <div class="text-danger d-none" id="sessionSummaryError">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <form
                                        action="{{ route('codetrek.session.delete', ['session_id' => $session->id, 'applicant_id' => $codeTrekApplicant->id]) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="p-0 m-0 btn btn-link"
                                            onclick="return confirm('Are you sure you want to delete?')"><i
                                                class="text-danger fa fa-trash fa-lg"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
