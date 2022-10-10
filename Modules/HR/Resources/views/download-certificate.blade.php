@extends('report::layouts.finance')
@section('content')
<div class="w-md-600 w-300 mx-auto pt-5 text-center">
    <h2>You can download the internship certificate from the download button:</h2><br>
    <h2 class="mb-2 fz-72 fz-md-150 "><i class="fa fa-check text-success rounded-circle p-3 bg-white"></i></h2>
		<div class="w-md-600 w-300 mx-auto pt-5 text-center">
    <a type="submit" target="_blank" href="{{route('applications.getInternshipCertificate', $applicants->id)}}" class="w-md-600 w-300 mx-auto pt-5 text-center">
        <i class="fa fa-file fa-2x text-primary btn-file mt-3 "></i>&nbsp;Download Certificate
    </a>
    </div>
</div>

@endsection
