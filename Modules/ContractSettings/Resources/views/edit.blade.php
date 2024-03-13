<div class="modal fade" id="contractEditformModal{{$contract->id}}" tabindex="-1" role="dialog" aria-labelledby="contractformModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contractformModalLabel">Add Contract Template Link</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary d-none" id="contractFormSpinner"></div>
            </div>
            <div class="contract modal-body">
                <form action="{{ route('contractsettings.update', $contract->id)}}" method="POST" id="contractForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <div class='form-group'>
                            <label class="field-required" for="contractfield">Contract Type</label><br>
                            <select name="contract_type" class="form-control">
                                @foreach(config('contractsettings.billing_level') as $key => $value)
                                    <option value="{{ $key }}" @if($key == $contract->contract_type) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label for="contractfield">Add Link</label><strong class="text-danger">*</strong></label>
                        <input type="text" name="contract_template" class="form-control"  id="contract_template" aria-describedby="Help" placeholder="Link" value= {{$contract->contract_template}} >
                        <div class="d-none text-danger" name="error" id="contracterror"></div>
                    </div>
                    <div class="d-none text-danger" name="error" id="domainerror"></div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="contract">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>