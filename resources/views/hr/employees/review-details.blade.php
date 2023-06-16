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
            <form action="/save-review-details" method="POST" class="d-flex">
                @csrf
                <label for="hr_id">HR:</label>


                <select class="btn bg-light text-left" name="centre_name" onchange="this.form.submit()">
                    <option value="" selected="selected">Select HR</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                
                <br><br>
                <label for="mentor_id">Mentor:</label>
                <select name="mentor_id" id="mentor_id">
                    <option value="">Select Mentor</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
                <br><br>
                <label for="manager_id">Manager:</label>
                <select name="manager_id" id="manager_id">
                    <option value="">Select Manager</option>
                    @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                    @endforeach
                </select>
            </form>
            <button class="btn btn-primary" type="submit" value="Save">Save</button>
            <br>
            <br>


            <div class="review-cards">
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
