@extends('layouts.app')
@section('content')

<div class="container">
  <br>
  @include('hr.employees.sub-views.menu')
  <br><br>
  <div class="container">
    <div>
      <table class="table table-bordered table-striped bg-white text-dark w-full">
        <thead class="bg-secondary text-white text-center align-middle ">
          <tr>
            <th class="text-center">Category</th>
            <th class="text-center">Mark as Read</th>
            <th class="text-center">Post Suggestion</th>
          </tr>
        </thead>
        <tbody>
          <form method="POST" action="{{ route('employees.resources.guideline',$employee->id) }}" enctype="multipart/form-resource" id="addResourceForm">
              @csrf
            @foreach ( $resources as $index => $resource)
              <tr>
                <td class="text-center">
                  <a href="{{$resource['resource_link']}}" target="_blank"> {{$resource->category['name']}}</a>
                  <input type="hidden" name="category[{{$index}}]" value="{{$resource->category['name']}}" />
                </td>
                <td class="text-center">
                  <input type="checkbox" name="mark_as_read[{{$index}}]" value="checked" />
                </td>
                <td class="text-center ">
                  <textarea type="text" name="post_suggestion[{{$index}}]" class="form-control-plaintext bg-light text-dark text-center bold" placeholder="post here your suggestion"></textarea>
                </td>
              </tr>
            @endforeach
          </form>
        </tbody>
      </table>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" form="addResourceForm" id="save-btn-action">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection
