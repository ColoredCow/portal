@section('popup',' Add new applicant')

@can('codetrek_applicant.create')
    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#photoGallery">
        <a><i class="fa fa-plus"></i>@yield('popup')</a>
    </button>
@endcan
<div id="add_applicant_details_form">
    <div class="modal fade" id="photoGallery" tabindex="-1" role="dialog" aria-labelledby="photoGalleryLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('codetrek.store')}}" method="POST" id='applicant_form' enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><strong>Add new applicant</strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="first_name" class="field-required">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="firstName" placeholder="Enter first name" required="required" value="">
                                <span class="text-danger" id="firstNameError"></span>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="last_name" class="field-required">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="lastName" placeholder="Enter last name" required="required" value="">
                                <span class="text-danger" id="lastNameError"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="email" class="field-required">Email</label>
                                <input type="email" class="form-control" name="email_id" id="email" placeholder="Enter applicant email" required="required" value="">
                                <span class="text-danger" id="emailError"></span>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                 <label for="phone">Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone_no" placeholder="Enter Phone Number" maxlength="10" value="">
                                <span class="text-danger" id="phoneError"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="github_username" class="field-required">Github username</label>
                                <input type="text" class="form-control" name="github_username" id="githubUsername" placeholder="Enter applicant's username" required="required" value="">
                                <span class="text-danger" id="githubUsernameError"></span>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="start_date" class="field-required">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="startDate" required="required" value="">
                                <span class="text-danger" id="startDateError"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="university">Enter University</label>
                                <input type="text" class="form-control" name="university_name" id="universityName" placeholder="Enter University" value="">
                                <span class="text-danger" id="universityNameError"></span>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="course">Course</label>
                                <input type="text" class="form-control" name="course" id="courseName"
                                    placeholder="Enter course name" value="">
                                <span class="text-danger" id="courseNameError"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="graduation">Graduation Year</label>
                                <select v-model="graduationyear" name="graduation_year" id="graduationYear" class="form-control">
                                    <option value="">Select Graduation Year</option>
                                    @php
                                        $currentYear = date('Y');
                                        $endYear = $currentYear + 4;
                                    @endphp
                                    @for ($i = $endYear; $i >= 1990; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <span class="text-danger" id="graduationYearError"></span>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="centre" class="field-required">Centre Name</label>
                                <select name="centre" id="centreId" class="form-control" required>
                                    <option value="">Select Centre Name</option>
                                    @foreach ($centres as $centre)
                                        <option value="{{ $centre->id }}">{{ $centre->centre_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="centreIdError"></span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="mentor" class="field-required">Assign Mentor</label>
                                <select name="mentorId" id="mentorId" class="form-control" required>
                                    <option value="">Select Mentor Name</option>
                                    @foreach ($mentors as $mentor)
                                        @if ($mentor->name)
                                            <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger" id="mentorIdError"></span>
                            </div>
                            <div class="form-group offset-md-1 col-md-5">
                                <label for="domain" class="field-required">Domain Name</label>
                                <select name="domain" id="domain" class="form-control" required>
                                    <option value="">Select Domain Name</option>
                                    @foreach (config('codetrek.domain') as $key => $domain)
                                        <option value="{{ $domain['slug'] }}">{{ $domain['label'] }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="domainError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary save-btn" id="submitButton">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#applicant_form').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $('#submitButton').prop('disabled', true);

            clearValidationErrors();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#photoGallery').modal('hide');
                    location.reload();
                },
                error: function(jqXHR) {
                    if (jqXHR.status === 422) {
                        var errors = jqXHR.responseJSON.errors;
                        displayValidationErrors(errors);
                    } else {
                        alert('An error occurred. Please try again later.');
                    }
                    $('#submitButton').prop('disabled', false);
                }
            });
        });

        // Function to display validation errors in the form
        function displayValidationErrors(errors) {
    var firstNameError = errors['first_name'] ? errors['first_name'][0] : '';
    $('#firstNameError').text(firstNameError);

    var lastNameError = errors['last_name'] ? errors['last_name'][0] : '';
    $('#lastNameError').text(lastNameError);

    var emailError = errors['email_id'] ? errors['email_id'][0] : '';
    $('#emailError').text(emailError);

    var phoneError = errors['phone'] ? errors['phone'][0] : '';
    $('#phoneError').text(phoneError);

    var githubUsernameError = errors['github_username'] ? errors['github_username'][0] : '';
    $('#githubUsernameError').text(githubUsernameError);

    var startDateError = errors['start_date'] ? errors['start_date'][0] : '';
    $('#startDateError').text(startDateError);

    var universityNameError = errors['university_name'] ? errors['university_name'][0] : '';
    $('#universityNameError').text(universityNameError);

    var courseNameError = errors['course'] ? errors['course'][0] : '';
    $('#courseNameError').text(courseNameError);

    var graduationYearError = errors['graduation_year'] ? errors['graduation_year'][0] : '';
    $('#graduationYearError').text(graduationYearError);

    var centreIdError = errors['centre'] ? errors['centre'][0] : '';
    $('#centreIdError').text(centreIdError);

    var mentorIdError = errors['mentorId'] ? errors['mentorId'][0] : '';
    $('#mentorIdError').text(mentorIdError);

    var domainError = errors['domain'] ? errors['domain'][0] : '';
    $('#domainError').text(domainError);
}

        function clearValidationErrors() {
            $('.text-danger').text('');
        }
    });
</script>
