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
                        <th>Enter new email</th>
                        <!-- Add other fields as needed -->
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $row)
                        <tr>
                            <td>{{ $row[1] }}</td>
                            <td>{{ $row[0] }}</td>
                            <td> <a href="">Send email</a> </td>
                            <td>                     <input type="text" id="email" name="email" class="save email" placeholder="email" required>
                            </td>
                            <td>
                                <input type="hidden" name="timestamp[]" value="{{ $row[0] }}">
                                <input type="hidden" name="full_name[]" value="{{ $row[1] }}">
                                <input type="checkbox" class="approved-checkbox" name="approved[]"" value="approved">
                                Approve
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
            $('.approved-checkbox').change(function() {
                if ($(this).is(':checked')) {
                    console.log($(this))
                    var form = $(this).closest('form'); // Find the closest form element
                    var row = $(this).closest('tr'); // Find the closest table row
                    var formData = {
                        timestamp: row.find('input[name="timestamp[]"]').val(),
                        full_name: row.find('input[name="full_name[]"]').val(),
                    }

                    // Make an AJAX request to submit the form data
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: formData,
                        success: function(response) {
                            console.log(response)
                        },
                        error: function(err) {
                            console.error(err)
                        }
                    })
                }
            });
        })
    </script>
@endsection
