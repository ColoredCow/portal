@extends('codetrek::layouts.master')
@section('heading', 'CodeTrek')
@section('content')
    <div class="container" id="applicant">
        <div class="col-lg-12 d-flex justify-content-between align-items-center mx-auto">
            <div>
                <h1>@yield('heading')</h1>
            </div>
            <div>
                @include('codetrek::modals.add-applicant-modal')
            </div>
        </div>
        <br><br>
        <ul class="nav nav-pills d-flex justify-content-between">
            @php
                $request = request()->all();
            @endphp
            <div class="d-flex">
                <li class="nav-item mr-3">
                    @php
                        $request['tab'] = 'applicants';
                    @endphp
                    <a class="nav-link {{ request()->input('tab', 'applicants') == 'applicants' ? 'active' : '' }} "
                        href="{{ route('codetrek.index', $request) }}"><i class="fa fa-list-ul"></i> Applicants</a>
                </li>
                <li class="nav-item">
                    @php
                        $request['tab'] = 'reports';
                    @endphp
                    <a class="nav-link {{ request()->input('tab', 'active') == 'reports' ? 'active' : '' }}"
                        href="{{ route('codetrek.index', $request) }}"><i class="fa fa-pie-chart"></i> Reports</a>
                </li>
            </div>
            <div>
                <form action="{{ route('codetrek.index') }}" id="centreFilterForm">
                    <div class="form-group ml-25 w-180">
                        @can('codetrek_applicant.create')     
                            <select class="form-control bg-light" name="centre" id="centre" onchange="document.getElementById('centreFilterForm').submit();">
                                <option value="" {{ !request()->has('centre') || empty(request()->get('centre')) ? 'selected' : '' }}>
                                    {!! __('All Centres') !!}
                                </option>
                                @foreach ($centres as $centre)
                                    <option value="{{ $centre->id }}" {{ request()->get('centre') == $centre->id ? 'selected' : '' }}>
                                        {{ $centre->centre_name }}
                                    </option>
                                @endforeach
                            </select>
                        @endcan
                        <input type="hidden" name="status" value="{{ $request['status'] ?? '' }}">
                        <input type="hidden" name="name" value="{{ request()->get('name') }}">
                    </div>
                </form>
            </div>
            <form class="d-md-flex justify-content-between ml-md-3" action="{{ route('codetrek.index') }}">
                <div class="d-flex justify-content-end">
                    <input type="text" name="name" class="form-control" id="name"
                        placeholder="Enter the Applicant name" value= "{{ request()->get('name') }}">
                    <input type="hidden" name="status" value="{{ $request['status'] ?? '' }}">
                    <input type="hidden" name="centre" value="{{ request()->get('centre') }}">
                    <button class="btn btn-info h-40 ml-2 text-white">Search</button>
                </div>
            </form>
        </ul>
        <br>
        @php
            $name = request()->input('name');
            $centre = request()->get('centre');
        @endphp
        <ul class="nav nav-pills d-flex justify-content-between">
            <div class='d-flex justify-content-between'>
                <li class="nav-item mr-3">
                    <a href="{{ route('codetrek.index', ['name' => $name ,'centre' => $centre , 'status' => 'active']) }}"
                        class="nav-link btn-nav {{ request()->input('status') !== 'inactive' && request()->input('status') !== 'completed' ? 'active' : '' }}"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                        <span class="d-inline-block h-18 w-20">{!! file_get_contents(public_path('icons/clipboard-check.svg')) !!}</span>
                        Active({{$statusCounts['active']}})</a>
                </li>
                <li class="nav-item mr-3">
                    <a href="{{ route('codetrek.index', ['name' => $name , 'centre' => $centre , 'status' => 'inactive']) }}"
                        class="nav-link btn-nav {{ request()->input('status') == 'inactive' ? 'active' : '' }}"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                        <span class="d-inline-block h-18 w-20">{!! file_get_contents(public_path('icons/x-circle.svg')) !!}</span>
                        Inactive({{$statusCounts['inactive']}})</a>
                </li>
                <li class="nav-item mr-3">
                    <a href="{{ route('codetrek.index', ['name' => $name , 'centre' => $centre , 'status' => 'completed']) }}"
                        class="nav-link btn-nav {{ request()->input('status') == 'completed' ? 'active' : '' }}"
                        onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='none'">
                        <span class="d-inline-block h-18 w-20"> {!! file_get_contents(public_path('icons/person-check.svg')) !!} </span>
                        Completed({{$statusCounts['completed']}})</a>
                </li>
            </div>
            <form action="{{ route('codetrek.index') }}" id="sortingForm">
                <div class="form-group w-120">
                    <select class="form-control bg-light" name="order" id="order" onchange="document.getElementById('sortingForm').submit();">
                        <option value="">
                            Sort By
                        </option>
                        <option value="name"  {{ request()->get('order') == 'name' ? 'selected' : ''}}>
                            Name
                        </option>
                        <option value="date" {{ request()->get('order') == 'date' ? 'selected' : ''}}>
                            Date
                        </option>
                    </select>
                    <input type="hidden" name="status" value="{{ $request['status'] ?? '' }}">
                    <input type="hidden" name="centre" value="{{ $request['centre'] ?? '' }}">
                    <input type="hidden" name="name" value="{{ request()->get('name') }}">
                </div>
            </form>
        </ul>
        @if (request()->input('tab', 'active') == 'active' || request()->tab == 'applicants')
            <div>
                <br>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr class="text-center sticky-top">
                            <th class="col-md-4">Name</th>
                            <th class="col-md-2">Days in CodeTrek</th>
                            <th>Level</th>
                            <th>Mentor Assigned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applicants as $applicant)
                            <tr>
                                <td>  
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <h4>{{ $applicant->first_name }} {{ $applicant->last_name }}</h4>
                                        </div>
                                    </div>
                                    <span class="mr-1 text-truncate"><i
                                            class="fa fa-envelope-o mr-1"></i>{{ $applicant->email }}</span>
                                    <br>
                                    @if ($applicant->phone)
                                        <span class="mr-1"><i class="fa fa-phone mr-1"></i>{{ $applicant->phone }}</span>
                                        <br>
                                    @endif
                                    <div>
                                        @if ($applicant->university)
                                            <span class="mr-1"><i
                                                    class="fa fa-university mr-1"></i>{{ $applicant->university }}</span>
                                        @endif
                                    </div>
                                    @can('codetrek_applicant.update')
                                    <div class="mb-2 fz-xl-14 text-secondary d-flex flex-column">
                                        <div class="d-flex text-white my-2">
                                            <a href="{{ route('codetrek.edit', $applicant->id) }}"
                                                class="btn-sm btn-primary mr-1 text-decoration-none" target="_self">View</a>
                                            <a href="{{ route('codetrek.evaluate', $applicant->id) }}"
                                                class="btn-sm btn-primary mr-1 text-decoration-none"
                                                target="_self">Evaluate</a>
                                        </div>
                                    </div>
                                    @endcan
                                </td>
                                <td>
                                    {{ $applicant->days_in_codetrek }} days
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <span class="{{ config('codetrek.rounds.' . $applicant->latest_round_name . '.class') }} badge-pill mr-1 mb-1 fz-16">
                                            {{ config('codetrek.rounds.' . $applicant->latest_round_name . '.label') }}
                                        </span>
                                    </div>                                    
                                </td>
                                <td>
                                    <div class="d-flex align-items-center"> 
                                        @if ($applicant->mentor)
                                            <div class="col">
                                                <div class="d-flex align-items-center"> 
                                                    <img src="{{ $applicant->mentor->avatar }}" class="w-35 h-30 rounded-circle ">
                                                    <h4 class="ml-2 mb-0">{{ $applicant->mentor->name }}</h4> 
                                                </div>
                                            </div>
                                        @else
                                            <h4 class="ml-2">No Mentor Assigned</h4>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                         <tr>
                            <td colspan="4">No Applicant Found</td>
                         </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{$applicants->links()}}
        @elseif (request()->status == 'reports')
            <div>
                <br><br>
                <p align="center">Coming Soon</p>
            </div>
        @endif
    </div>
@endsection
@section('vue_scripts')
    <script>
        new Vue({
            el: '#applicant',
            data() {
                return {
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    github_username: '',
                    start_date: '',
                    university: '',
                    course: '',
                    graduationyear: ''
                }
            },
            methods: {
                submitForm: async function(formId) {
                    $('.save-btn').attr('disabled', true);
                    let formData = new FormData(document.getElementById(formId));
                    await axios.post('{{ route('codetrek.store') }}', formData)
                        .then((response) => {
                            $('.save-btn').removeClass('btn-dark').addClass('btn-primary');
                            $('.save-btn').attr('disabled', false);
                            this.$toast.success("Applicant added successfully", {
                                duration: 5000
                            });
                            $("#photoGallery").modal('hide');
                            location.reload();
                        })
                        .catch((error) => {
                            let errors = error.response.data.errors;
                            $('.save-btn').attr('disabled', false);
                            if (errors) {
                                Object.keys(errors).forEach(function(key) {
                                    this.$toast.error(errors[key][0]);
                                });
                            } else {
                                this.$toast.error("Error submitting form, please fill required fields");
                            }
                        });
                }
            }
        });
    </script>
@endsection
