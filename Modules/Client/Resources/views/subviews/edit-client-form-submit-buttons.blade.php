@php 
    $isNext = $isNext ?? true;
@endphp

<button class="btn btn-primary client_edit_form_submission_btn btn-theme-gray-lighter mr-3" data-submit-action="save-and-exit" type="button" >Save and Exit</button>

@if($isNext)
<button class="btn btn-primary client_edit_form_submission_btn" data-submit-action="next" type="button" >Next</button>
@endif
