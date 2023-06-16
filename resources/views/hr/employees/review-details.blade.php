@extends('layouts.app')

@section('content')
    @php
        function getStatusOptions()
        {
            return '
                <select class="form-control" name="status">
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
            ';
        }
    @endphp

    <div class="container mb-20">
        <br>
        @include('hr.employees.sub-views.menu')
        <br>
        <div>
            <br>
            <h2>{{ $employee->name }}'s review details</h2>
            <br>
            <br>
            <form method="POST" action="{{ route('update.employee.reviewers', $employee->id) }}">
                @csrf
                <div class="d-flex justify-content-between">
                    @foreach(config('constants.employee-reviewers') as $key => $role)
                        <div>
                            <label for="{{ $role }}">{{ $role }}:</label>
                            <select class="pt-0 ml-2 btn bg-light text-left" name="{{ $key }}" onchange="this.form.submit()">
                                <option value="" selected="selected">Select {{ $role }}</option>
                                @foreach($employees as $employe)
                                    <option value="{{ $employe->id }}" {{ $employee->toArray()[$key] == $employe->id ? 'selected' : '' }}>
                                        {{ $employe->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
            </form>

            <div class="review-cards mt-5">
                <input type="hidden" name="assessment_id" value="{{ $employee->id }}">
                <!-- Quarter 1 Review Card -->
                <div class="card mb-4">
                    <div class="card-header review-card-header">
                        <h4 class="font-weight-bold">Quarterly Review (20/05/2023)</h4>
                    </div>
                    <div class="card-body review-card-body" style="display: none;">
                        <div class="mb-2">Last reviewed at: {{ $employee->created_at }}</div>
                        <div>Next review due: {{ $employee->created_at }}</div>
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
                                    <td>{!! getStatusOptions() !!}</td>
                                    <td>{!! getStatusOptions() !!}</td>
                                    <td>{!! getStatusOptions() !!}</td>
                                    <td>{!! getStatusOptions() !!}</td>
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
