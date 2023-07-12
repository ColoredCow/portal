@extends('layouts.app')

@section('content')
    <div class="container">
        <br>
        @include('hr.employees.menu')
        <br><br>
        <form action="{{ route('approve.send-basic-mail') }}" method="POST">
            @csrf
            <div class="d-flex mb-3">
                <h1>New Joinees</h1>
                <button type="button" class="btn btn-success ml-auto" data-toggle="modal" data-target="#popupModal">
                    Send Basic Details Mail
                </button>
                <br>
            </div>

            <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="popupModalLabel">Send Basic Details Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body col-md-12">
                            <div class="form-group col-md-12">
                                <label for="first_name" class="field-required">Name</label>
                                <input type="text" class="form-control" name="name" id="firstName"
                                    placeholder="Enter joinee's name" required="required" value="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="first_name" class="field-required">Email</label>
                                <input type="text" class="form-control" name="email" id="firstName"
                                    placeholder="Enter joinee's email" required="required" value="">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary save-btn"
                                v-on:click="submitForm('applicant_form')">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                            <td class="align-middle">{{ $row[1] }}</td>
                            <td class="align-middle">{{ $row[0] }}</td>
                            <td class="align-middle"><a href="">Send email</a></td>
                            <td class="align-middle">
                                <input type="email" id="email_{{ $key }}" name="email[]"
                                    class="form-control email" placeholder="Enter new email" required>
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
