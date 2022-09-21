@extends('hr::layouts.master')
@section('content')
    <div :class="[showResumeFrame ? 'container-fluid' : 'container']" id="page_hr_applicant_edit">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark sticky-top">
                <th><strong>Resume</strong></th>
                <th><strong>Why you think the resume is desired?</strong></th>
            </thead>
            @foreach ($data as $datas)
                <tr>
                    <td><a href="{{ $datas->resume }}"><i class="fa fa-file"></i></a></td>
                    <td>{{ $datas->value }}</td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection
