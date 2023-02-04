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
                $request['status'] = 'applicants';
            @endphp
             <a class="nav-link {{ (request()->input('status', 'applicants') == 'applicants')  ? 'active' : '' }} " href="{{ route('codetrek.index', $request)  }}"><i class="fa fa-list-ul"></i> Applicants</a>
        </li>

        <li class="nav-item">
            @php
                $request['status'] = 'reports';
            @endphp
            <a class="nav-link {{ (request()->input('status','active')== 'reports') ? 'active' : '' }}"  href="{{ route('codetrek.index', $request)  }}"><i class="fa fa-pie-chart"></i> Reports</a>
        </li>
    </ul>
    @if (request()->input('status','active') == 'active'||request()->status=='applicants')
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
                    <tr>
                        <td>
                            @foreach ($applicants as $applicant )
                                {{$applicant->first_name}}
                                {{$applicant->last_name}}
                                <br><br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($applicants as $applicant )
                             -
                            <br><br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($applicants as $applicant )
                                {{$applicant->status}}
                                <br><br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($applicants as $applicant )
                             -
                            <br><br>
                            @endforeach
                        </td>
                    </tr> 
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
                graduation_year: ''
            }
        },
        methods: {
            submitForm: async function(formId) {
                $('.save-btn').attr('disabled', true);
                let formData = new FormData(document.getElementById(formId));
                $('.save-btn').removeClass('btn-primary').addClass('btn-dark');
                await axios.post('{{ route('codetrek.store') }}', formData)
                    .then((respose) => {
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
                            var errormessage = errors[error].join().replace('id', '');
                            this.$toast.error(errormessage);
                        }
                    });
            }
        }
    });
</script>
@endsection
