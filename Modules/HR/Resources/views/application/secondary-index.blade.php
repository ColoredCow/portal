@extends('layouts.app')

@section('content')

<div class="container">
    <br>
    @include('hr.menu')
    <br>
    <div class="row">
        <div class="col-md-6">
            <h1>Applications</h1>
        </div>
    </div>
    <div class="nav nav-tabs" id="recruitmentTabs" role="tablist">
        <button class="nav-link active" id="todayInterviewsButton" data-toggle="tab" data-target="#todayInterviewsTab" type="button" role="tab" aria-controls="todayInterviewsTab" aria-selected="true">Today's Interviews</button>
        <button class="nav-link" id="applicationTableButton" data-toggle="tab" data-target="#applicationTableTab" type="button" role="tab" aria-controls="applicationTableTab" aria-selected="false">Application Table</button>
    </div>
    <div class="tab-content" id="recruitmentTabsContent">
        <div class="tab-pane fade show active" id="todayInterviewsTab" role="tabpanel" aria-labelledby="todayInterviewsTab">
            @include('hr::application.today-interviews')
        </div>
        <div class="tab-pane fade" id="applicationTableTab" role="tabpanel" aria-labelledby="applicationTableTab">
            <table class="table table-striped table-bordered" id="applicants_table">
                <thead>
                    <th>Name</th>
                    <th>Details</th>
                    <th>
                        <span class="dropdown-toggle c-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="assigneeDropdown">Assignee</span>
                        <div class="dropdown-menu" aria-labelledby="assigneeDropdown">
                            <span class="dropdown-item-text fz-12">Filter by assignee</span>
                            @foreach ($assignees as $assignee)
                            @php
                            $target = route(request()->route()->getName(), ['assignee' => [$assignee->id]]);
                            $class = in_array($assignee->id, request()->get('assignee') ?? []) ? 'visible' : 'invisible';
                            @endphp
                            <a class="dropdown-item" href="{{ $target }}">
                                <i class="fa fa-check fz-12 {{ $class }}"></i>
                                <img src="{{ $assignee->avatar }}" alt="{{ $assignee->name }}"
                                    class="w-20 h-20 rounded-circle mr-1">
                                <span>{{ $assignee->name }}</span>
                            </a>
                            @endforeach
                        </div>
                    </th>
                    <th>
                        <span class="dropdown-toggle c-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="statusDropdown">Status</span>
                        <div class="dropdown-menu" aria-labelledby="statusDropdown">
                            <span class="dropdown-item-text fz-12">Filter by status</span>
                            @foreach ($tags as $tag)
                                @php
                                    $target = request()->fullUrlWithQuery(['tags' => [
                                    $tag->id
                                    ]]);
                                    $class = in_array($tag->id, request()->get('tags') ?? []) ? 'visible' : 'invisible';
                                @endphp
                                <a class="dropdown-item d-flex align-items-center" href="{{ $target }}">
                                    <i class="fa fa-check fz-12 mr-1 {{ $class }}"></i>
                                    <div class="rounded w-13 h-13 d-inline-block mr-1"
                                        style="background-color: {{$tag->background_color}};color: {{$tag->text_color}};"></div>
                                    <span>{{ $tag->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </th>
                </thead>
                <tbody>
                    @forelse ($applications as $application)
                        @include('hr::application.render-application-row')
                    @empty
                    <tr>
                        <td colspan="100%" class="text-center">No application found for this filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
          {{ $applications->links() }}
        </div>
    </div>
</div>
@endsection