@php
$name = '';
$updateAction = '';
$deleteAction = '';
$class='d-none';
$btnText='';
if (isset($alias)) {
    $class='';
    $btnText='update';
    $name = $alias->name;
    $updateAction = route('universities.aliases.update',$alias);
    $deleteAction = route('universities.aliases.destroy',$alias);
}
@endphp
<div class="card mb-5 update-card">
    <div class="card-body">
        <form class="alias-form d-flex flex-row align-items-center" action="{{ $updateAction }}" method="POST" name="updateForm">
            @csrf
            <div class="method">
                @method('PUT')
            </div>
            <input type="hidden" name="hr_university_id" value="{{$university->id}}">
            <span class="text-danger help-block hr_university_id-feedback"></span>
            <div class="col-md-6 mb-3">
                <label for="name" class="field-required"> Alias Name</label>
                <input type="text" class="form-control" name="name" placeholder="Name" value="{{$name}}" required>
                <span class="text-danger help-block name-feedback"></span>
            </div>
            <button class="btn btn-primary w-100 btn-update py-1.33 mt-1 mt-xl-2" value="{{$btnText}}" type="submit">
                <i class="fa fa-circle-o-notch fa-spin d-none loader"></i>
                <span class="btn-text">{{ucfirst($btnText)}}</span>
                <i class="fa fa-check text-success fa-lg d-none icon" aria-hidden="true"></i>
            </button>
            <button type="button" title="Delete" class="update {{ $class }} btn btn-danger delete-form ml-1 w-100 py-1.33 mt-1 mt-xl-2">
                <i class="fa fa-circle-o-notch fa-spin d-none delete-loader"></i>
                <span class="delete-text">Remove</span>
            </button>
            <button type="button" class="ml-1 btn btn-danger w-100 remove-alias add d-none py-1.33 mt-1 mt-xl-2">Remove</button>
        </form>
        <form class="update {{ $class }} remove-form" action="{{ $deleteAction }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
