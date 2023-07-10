@extends('layouts.app')

@section('content')
    <div class="container">
            <br>
            @include('hr.employees.menu')
            <br><br>
        <div class="col-md-12">
            <h1>New Joinee's</h1>
            <br>
        </div>
        <form id="approvalForm" method="POST" action="{{ route('approve.joinees') }}">
            @csrf
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr class="sticky-top">
                        <th>Full Name</th>
                        <th>Last Updated</th>
                        <th>Send email to infra</th>
                        <!-- Add other fields as needed -->
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                    @dd($data)
                        <tr>
                            <td>{{ $row[1] }}</td>
                            <td>{{ $row[0] }}</td>  
                            <td> <a href="">Send email</a> </td>  
                            <td>
                                <input type="hidden" name="timestamp[]" value="{{ $row[0] }}">
                                <input type="hidden" name="full_name[]" value="{{ $row[1] }}">
                                <input type="checkbox" name="approved[]" value="approved"> Approve
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>        
    </div>
        
    <script>
        $(document).ready(function() {
            // Handle checkbox change event
            $('input[name="approved[]"]').change(function() {
                if ($(this).is(':checked')) {
                    // Submit the form
                    $('#approvalForm').submit();
                }
            });
        });
    </script>
@endsection
