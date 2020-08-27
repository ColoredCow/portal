@extends('layouts.app')
@section('content')
<div class="container" >
@include('status', ['errors' => $errors->all()])
<div class="card">
    <div class="card-header">
       Edit Slot
    </div>
    <div class="card-body">
        <form action="{{ route("hr.slots.update",$slot) }}" method="POST">
             @csrf
            @method('PATCH')
            <div class="row">
            <div class="form-group col">
                <label for="starts_at">Start Time*</label>
                <input type="datetime-local" id="starts_at" name="starts_at" class="form-control " value="{{date_create($slot->starts_at)->format('Y-m-d\TH:i:s')}}" required>
            </div>
            <div class="form-group col">
                <label for="ends_at">End time*</label>
                <input type="datetime-local" id="ends_at" name="ends_at" class="form-control" value="{{date_create($slot->ends_at)->format('Y-m-d\TH:i:s')}}" required>
            </div>
            </div>
            <div>
                <input class="btn btn-success" type="submit" value="Update">
            </div>
        </form><br>
        <form action="{{ route("hr.slots.delete",$slot) }}" method="POST" >
                @csrf
                @method('delete')
                    <input type="submit" class='btn btn-danger' value="Delete">
        </form>

    </div>
</div>  
</div>
@endsection
