@section('popup',' Add new applicant')

<button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#photoGallery">
    <a><i class="fa fa-plus"></i>@yield('popup')</a>
</button>
<div id="add_applicant_details_form">
<div class="modal fade" id="photoGallery" tabindex="-1" role="dialog" aria-labelledby="photoGalleryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST" >
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
                        <input type="text" class="form-control" name="name" id="first_name" placeholder="Enter first name"
                            required="required" value="">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="last_name" class="field-required">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name"
                            required="required" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="email" class="field-required">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter applicant email"
                            required="required" value="">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="github_username" class="field-required">Github username</label>
                        <input type="text" class="form-control" name="github_username" id="github_username" placeholder="Enter applicant's username"
                            required="required" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="start_date" class="field-required">Start Date</label>
                        <input type="date" class="form-control" name="start_date" id="start_date" required="required" value="">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="university" class="field-required">Enter University</label>
                        <input type="text" class="form-control" name="university" id="university" placeholder="Enter University"
                            required="required" value="">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="Course" class="field-required">Course</label>
                        <input type="text" class="form-control" name="course" id="course" placeholder="Enter course name"
                            required="required" value="">
                    </div>
                    <div class="form-group offset-md-1 col-md-5">
                        <label for="graduation_year" class="field-required">Graduation Year</label>
                        <select v-model="graduation_year" name="graduation_year" id="graduation_year" class="form-control" required>
                            <option value="">Select Graduation Year</option>
                            <?php 
                                 $currentYear = date('Y');
                                 $endYear = $currentYear + 4;
                                      for ($i=1990; $i<=$endYear; $i++) {
                                          echo '<option value="'.$i.'">'.$i.'</option>';
                                      } 
                            ?>
                         </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="phone_no" class="field-required">Phone Number</label>
                        <input type="tel" class="form-control" name="phone_no" id="course" placeholder="Enter Phone Number"
                            required="required"  maxlength="10" value="">
                    </div>
                </div>
            </div>
                  <div class="card-footer">
                     <button type="button" class="btn btn-primary" id="save-btn-action">Create</button>
                 </div>
            </form>
         </div>
     </div>
    </div>
</div>