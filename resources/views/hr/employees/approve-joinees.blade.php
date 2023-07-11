@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        @include('hr.employees.menu')
        <br><br>
        <div class="col-md-12">
            <h1>New Joinees</h1>
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
                            <td>
                                <form method="GET" action="{{ route('infra.mail') }}">
                                    @csrf
                                    <input type="hidden" name="data[0]" value="{{ $row[0] }}">
                                    <input type="hidden" name="data[1]" value="{{ $row[1] }}">
                                    <button type="submit"class="btn btn-transparent text-primary">Send email</button>
                                </form>
                            </td>
                            <td> <input type="text" id="email" name="email" class="save email" placeholder="email">
                            </td>
                            <td class="align-middle">
                                <input type="hidden" name="timestamp[]" value="{{ $row[0] }}">
                                <input type="hidden" name="full_name[]" value="{{ $row[1] }}">
                                <input type="checkbox" class="approved-checkbox" name="approved[]" value="approved"
                                    disabled>
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
            // Handle email input change event
            $('.email').on('input', function() {
                var key = $(this).attr('id').split('_')[1];
                var approveCheckbox = $('input[name="approved[]"]').eq(key);

                // Enable or disable the approve checkbox based on the email input value
                if ($(this).val().trim() !== '') {
                    approveCheckbox.prop('disabled', false);
                } else {
                    approveCheckbox.prop('disabled', true);
                    approveCheckbox.prop('checked', false);
                }
            });

            // Handle checkbox change event
            $('.approved-checkbox').change(function() {
                if ($(this).is(':checked')) {
                    var form = $(this).closest('form'); // Find the closest form element
                    var row = $(this).closest('tr'); // Find the closest table row
                    var key = row.index(); // Get the index of the table row
                    var formData = {
                        full_name: row.find('input[name="full_name[]"]').val(),
                        email: $('input[name="email[]"]').eq(key).val()
                    };

                    // Make an AJAX request to submit the form data
                    $.ajax({
                        url: form.attr('action'),
                        type: form.attr('method'),
                        data: formData,
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(err) {
                            console.error(err);
                        }
                    });
                }
            });
        });
    </script>
@endsection
