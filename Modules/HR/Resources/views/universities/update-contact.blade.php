@php
$name = $email = $phone = $designation = '';
$updateAction = '';
$deleteAction = '';
$class='d-none';
$btnText='';
if (isset($contact)) {
    $class='';
    $btnText='update';
    $name = $contact->name;
    $email = $contact->email;
    $phone = $contact->phone;
    $designation = $contact->designation;
    $updateAction = route('universities.contacts.update',$contact);
    $deleteAction = route('universities.contacts.destroy',$contact);
}
@endphp
<div class="card mb-5 update-card">
    <div class="card-body">
        <form class="contact-form" action="{{ $updateAction }}" method="POST" name="updateForm">
            @csrf
            <div class="method">
                @method('PUT')
            </div>
            <input type="hidden" name="hr_university_id" value="{{$university->id}}">
            <span class="text-danger help-block hr_university_id-feedback"></span>
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="name" class="field-required">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{$name}}" required>
                    <span class="text-danger help-block name-feedback"></span>
                </div>
                <div class="col-md-5 offset-md-1 mb-3">
                    <label for="email" class="field-required">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{$email}}" required>
                    <span class="text-danger help-block email-feedback"></span>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <label for="designation" class="field-required">Designation</label>
                    <input type="text" class="form-control" name="designation" value="{{$designation}}" placeholder="Designation" required>
                    <span class="text-danger help-block designation-feedback"></span>
                </div>
                <div class="col-md-5 offset-md-1 mb-3">
                    <label for="phone" class="field-required">Phone</label>
                    <input type="text" pattern="[6-9]{1}[0-9]{9}" class="form-control" name="phone" value="{{$phone}}" placeholder="Phone" title="The phone must be valid 10 digit, starting with 6,7 or 9" required>
                    <span class="text-danger help-block phone-feedback"></span>
                </div>
            </div>
             <button class="btn btn-primary w-100 btn-update" value="{{$btnText}}" type="submit">
                <i class="fa fa-circle-o-notch fa-spin d-none loader"></i>
                <span class="btn-text">{{ucfirst($btnText)}}</span>
                <i class="fa fa-check text-success fa-lg d-none icon" aria-hidden="true"></i>
            </button>
            <button type="button" title="Delete" class="update {{ $class }} btn btn-danger delete-form ml-1 w-100">
                <i class="fa fa-circle-o-notch fa-spin d-none delete-loader"></i>
                <span class="delete-text">Remove</span>
            </button>
            <button type="button" class="ml-1 btn btn-danger w-100 remove-contact add d-none">Remove</button>         
        </form>
        <form class="update {{ $class }} remove-form" action="{{ $deleteAction }}" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
