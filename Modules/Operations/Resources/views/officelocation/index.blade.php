@extends('layouts.app')

@section('content')


    <div class="modal fade" id="officelocationAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Locations</h5>
            </div>
    
            <form id="addform">
            <div class="modal-body">
                {{ csrf_field() }}

                <ul id="saveform_errlist"></ul>
                          <div class="mr-2 mt-2 mt-md-0 form-group">
                            <label>Center Head</label><br>
                            <select name="center_head" class="fz-14 fz-lg-16 w-120 w-220 form-control rounded border-0 bg-white" id="center_id">
                              <option value ="" selected> All Employees</option>
                              @foreach ( $centerHeads as $centerHead )
                                <option value ="{{ $centerHead->id }}" required> {{$centerHead->name}}</option>
                                
                              @endforeach
                            </select>
                           </div>
                      <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter your location" required>
                      </div>
                      <div class="form-group">
                        <label>Capacity</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" placeholder="Enter the strength" required>
                      </div>
    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </div>
            </form> 
          </div>
      </div>
    </div>
      <div class="modal fade" id="officelocationEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Locations</h5>
            </div>
    
          <form id="editformID">
            <div class="modal-body">
                {{ csrf_field() }}
                {{ method_field('PUT')}}

                <input type="hidden" name="id" id="id">
                <div class="mr-5 mt-2 mt-md-0 form-group">
                  <label>Center Head</label><br>
                  <select name="center_head" class="fz-14 fz-lg-16 w-120 w-220 form-control rounded border-0 bg-white" id="center_id">
                    <option value ="" selected> All Employees</option>
                    @foreach ( $centerHeads as $centerHead )
                      <option value ="{{ $centerHead->id }}"> {{$centerHead->name}} </option>
                      
                    @endforeach
                  </select>
                 </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter your location" required>
                      </div>
                      <div class="form-group">
                        <label>Capacity</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" placeholder="Enter the strength" required>
                      </div>
    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" id="editLocationBtn" class="btn btn-primary">update officelocation</button>
            </div>
            </div>
          </form>

        </div>
    </div>

    <div class="modal fade" id="officelocationDeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete the current location</h5>
          </div>

        <form id="deleteformId">
          <div class="modal-body">
              {{ csrf_field() }}
              @method('DELETE')

            <input type="text" id="delete_id">
            <h4>Are you sure  ? want to delete this data ?</h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" id="deleteLocationBtn" class="btn btn-danger"> Yes Delete</button>
          </div>
        </form>
      </div>
      </div>
    </div>

        <div class="container">
            <div class="row mt-3 text-primary text-lg-start">
                <h4> Office Location</h4>
            </div>
          </div>
            <div class="d-flex flex-row-reverse mr-25">
                <button type="button"  data-bs-toggle="modal" data-bs-target="#officelocationAddModal"class="btn btn-success mr-15 mb-4">
                    Add Office Location
                </button>
              </div>
            <div>
              <table class="table table-striped table-bordered w-75 ml-25 mb-15">
                  <thead class="thead-dark">
                      <tr class="top">
                      <th>Location</th>
                      <th>Capacity</th>
                      <th>Center Head</th>
                      <th>Actions</th>
                    </tr>
                    @foreach ($officelocations as $officelocation)    
                            <tr>
                              <td>{{ $officelocation->location }}</td>
                                <td>{{ $officelocation->capacity }}</td>

                                <td>
                              
                                 @if ( $officelocation->centerHead->user )
                                  <span data-html="true" data-toggle="tooltip" title="{{ $officelocation->centerHead->name }}" class="content tooltip-wrapper">
                                  
                                  <img src="{{ $officelocation->centerHead->user->avatar }}" class="w-35 h-30 rounded-circle mb-1"></a>
                                  @else
                                    - 
                                @endif
                                  </span> 
                                   @if ( $officelocation->centerHead->user )
                                  <span data-html="true" data-toggle="tooltip" title="{{ $officelocation->center_head }}" class="content tooltip-wrapper">
                                  <div class="text-primary fz-14">
                                    {{ $officelocation->centerHead->user->name }}</div>
                                  @else
                                      -
                                  @endif 
                                  </span>
                                    </td>
                                
                                <td>
                                    <button 
                                        type="button" 
                                        id="edit" 
                                        data-id="{{ $officelocation->id }}"
                                        data-center_head="{{ $officelocation->center_head }}"
                                        data-location="{{ $officelocation->location }}"
                                        data-capacity="{{ $officelocation->capacity }}"
                                        class="btn btn-sm btn-info ml-1 editbtn"
                                        >Edit</button>
                                        <button 
                                        type="button" 
                                        id="delete" 
                                        data-id="{{ $officelocation->id }}"
                                        class="btn btn-sm btn-danger ml-1 deletebtn">Delete</button>
                                </td>
                            </tr>
                    @endforeach
              </table>
            </div>
        </div>
    </div>
@endsection


   
    


  
 