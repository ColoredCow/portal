@extends('codetrek::layouts.master')
@section('heading','CodeTrek')
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
    <ul class="nav nav-pills">
        @php
          $request = request()->all();
        @endphp
        <li class="nav-item mr-3">
            @php
                $request['tab'] = 'applicants';
            @endphp
             <a class="nav-link {{ (request()->input('tab', 'applicants') == 'applicants')  ? 'active' : '' }} " href="{{ route('codetrek.index', $request)  }}"><i class="fa fa-list-ul"></i> Applicants</a>
        </li>

        <li class="nav-item">
            @php
                $request['tab'] = 'reports';
            @endphp
            <a class="nav-link {{ (request()->input('tab','active')== 'reports') ? 'active' : '' }}"  href="{{ route('codetrek.index', $request)  }}"><i class="fa fa-pie-chart"></i> Reports</a>
        </li>
    </ul>
    @if (request()->input('tab','active') == 'active'||request()->tab=='applicants')
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
                </thead>
                <tbody>
                    @foreach ($applicants as $applicant )
                        <tr>
                            <td><a href="{{route('codetrek.edit', $applicant->id) }}">{{$applicant->first_name}} {{$applicant->last_name}}</a></td>
                            <td>-</td>
                            <td>{{ config('codetrek.status.' . $applicant->status . '.label') }}</td>
                            <td>-</td>
                        </tr> 
                    @endforeach
                </tbody>
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
                        this.$toast.success("Applicant added successfully", { duration: 5000 });
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
