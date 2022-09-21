<!--<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>-->
    @extends('layouts.app')
    
    @section('content')
        
    <div class="container" id="page_hr_applicant_create">
        

        <div class="d-flex justify-content-between">
            <h1>Add New Volunteer</h1>
            
        </div>
        <div>
            @include('status', ['errors' => $errors->all()])
            <div class="card">
                <form method="post" action="{{ route('saveItem') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="card-body">
                        <div class="form-row mb-4">
                            <div class="col-md-5">
                                
                                <div class="form-group">
                                    <label for="title" class="field-required">Title</label>
                                    <input type="text" class="form-control" name="title" 
                                        placeholder="Title" required="required" >
                                </div>

                                <div class="form-group">
                                    <label for="description" class="field-required">Description</label>
                                    <input type="text" class="form-control" name="description" 
                                        placeholder="Enter Description" required="required" >
                                </div>
                                
                                <div class="form-group">
                                    <label for="type" class="field-required">Type</label>
                                    <input type="text" class="form-control" name="type" 
                                        placeholder="Type" required="required" value="volunteer" readonly >
                                </div>

                                <div class="form-group">
                                    <label for="domain" class="field-required">Domain</label>
                                    <input type="text" class="form-control" name="domain" 
                                        placeholder="Domain" required="required" >
                                </div>

                                <div class="form-group">
                                    <label for="start_date" >Start date</label>
                                    <input type="text" class="form-control" name="start_date" 
                                        placeholder=""  >
                                </div>

                                <div class="form-group">
                                    <label for="link" >Link</label>
                                    <input type="text" class="form-control" name="link" 
                                        placeholder=""  >
                                </div>

                               
                            </div>

                            <div class="col-md-5 offset-md-1">
                                <div class="form-group">
                                    <label for="name">End date</label>
                                    <input type="text" class="form-control" name="end_date" 
                                        placeholder="" >
                                </div>

                                <div class="form-group">
                                    <label for="facebook_post">Facebook post</label>
                                    <input type="text" class="form-control" name="facebook_post" 
                                        placeholder="" >
                                </div>

                                <div class="form-group">
                                    <label for="linkedin_post">Linkedin post</label>
                                    <input type="text" class="form-control" name="linkedin_post" 
                                        placeholder="" >
                                </div>

                                <div class="form-group">
                                    <label for="instagram_post">Instagram post</label>
                                    <input type="text" class="form-control" name="instagram_post" 
                                        placeholder="" >
                                </div>

                                <div class="form-group">
                                    <label for="posted_by">Posted by</label>
                                    <input type="text" class="form-control" name="posted_by" 
                                        placeholder="" >
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" name="status" 
                                        placeholder="" value="published" readonly>
                                </div>

                                


                                
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>
            
           
    </div>
    
    @endsection
<!--</body>
</html>-->