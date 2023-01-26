@extends('codetrek::layouts.master')
@section('heading','CodeTrek')
@section('content')
<div class="container">
     <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
          <div>
              <h1>@yield('heading')</h1>
          </div>
      <div>
        @include('codetrek::modals.add-applicant-modal')
     </div>
      </div><br><br>
     <ul class="nav nav-pills">
      @php
          $request = request()->all();
      @endphp
      <li class="nav-item mr-3">
          @php
              $request['status'] = 'applicants';
          @endphp
          <a class="nav-link {{ (request()->input('status', 'active') == 'applicants')  ? 'active' : '' }}" href="{{ route('codetrek.index', $request)  }}"><i class="fa fa-list-ul"></i> Applicants</a>
      </li>

      <li class="nav-item">
          @php
              $request['status'] = 'reports';
          @endphp
          <a class="nav-link {{ (request()->input('status', 'active') == 'reports') ? 'active' : '' }}"  href="{{ route('codetrek.index', $request)  }}"><i class="fa fa-pie-chart"></i> Reports</a>
      </li>

  </ul>
      @if (request()->status == 'applicants')
      <div>
        <br>
          <table class="table table-bordered table-striped">
               <thead class="thead-dark">
                   <tr class="text-center sticky-top">
                       <th class="col-md-4">Name</th>
                       <th class="col-md-2"> Days in CodeTrek</th>
                       <th> Status</th>
                       <th>Feedbacks</th>
                   </tr>
                   <td>
                    No applicant found
                   </td>
                   </table>
      </div>
      @elseif (request()->status=='reports')
      <div>
        <br><br>
        <p align="center">Coming Soon</p>
      </div>
      @endif
</div>
@endsection
