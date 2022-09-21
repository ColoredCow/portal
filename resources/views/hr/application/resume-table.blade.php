
@extends('hr::layouts.master')
@section('content')
<div :class="[showResumeFrame ? 'container-fluid' : 'container']" id="page_hr_applicant_edit">
<table class="table table-striped">
    <tr>
        <td><strong>Resume</strong></td>
        <td><strong>Why you think the resume is desired?</strong></td>
        </tr>
    <tr>
        @foreach ($data as $datas)
        <tr>
            <td><a href="{{$datas->resume}}"><i class="fa fa-file"></i></a></td>
            <td>{{$datas->value}}</td>
        </tr> 
        @endforeach 
    
</table>
</div>

@endsection