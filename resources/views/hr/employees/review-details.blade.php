@extends('layouts.app')

@section('content')
    <div class="container mb-20">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        <div>
            <br>
            <h2>{{$employee->name}}'s review details</h2>
            <br>
            <br>

            <div class="review-cards">
                <!-- Quarter 1 Review Card -->
                <div class="card mb-4">
                    <div class="card-header review-card-header">
                        <h4 class="font-weight-bold">Quarterly Review (20/05/2023)</h4>
                    </div>
                    <div class="card-body review-card-body" style="display: none;">
                        <div class="mb-2">Last reviewed at: {{ $employee->created_at}}</div>
                        <div>Next review due: {{ $employee->created_at}}</div>
                        <br>
                        <br>
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                            <tr class="sticky-top">
                                <th>Self review</th>
                                <th>Mentor review</th>
                                <th>HR review</th>
                                <th>Manager review</th>
                            </tr>
                                <tr>
                                    <td>
                                        <a>{{ $employee->name }}</a>
                                    </td>
                                    <td>
                                        @if ($employee->designation_id)
                                            {{ $employee->hrJobDesignation->designation }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                    @if ($employee->joined_on)
                                        <span>{{$employee->joined_on->format('d M, Y') }}</span>
                                        <span style="font-size: 10px;">&nbsp;&#9679;&nbsp;</span>
                                        <span>{{$employee->employmentDuration }}</span>
                                    @else
                                        -
                                    @endif
                                    </td>
                                    <td>
                                        @if($employee->user == null)
                                            0
                                        @else
                                            {{$employee->project_count}}
                                        @endif
                                    </td>
                                </tr>
                        </table>
                        <br>
                        <br>
                        <button class="btn btn-primary">Save</button> <!-- Save button -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-header review-card-header">
                        <h4 class="font-weight-bold">Quarterly Review (20/01/2023)</h4>
                    </div>
                    <div class="card-body review-card-body" style="display: none;">
                        <button class="btn btn-primary">Save</button> <!-- Save button -->
                    </div>
                </div>

                <!-- Add more Quarter Review Cards as needed -->

            </div>
        </div>
    </div>

    <script>
        // jQuery code to toggle card body visibility
        $(document).ready(function() {
            $('.review-card-header').click(function() {
                $(this).next('.review-card-body').slideToggle();
            });
        });
    </script>
@endsection