<div class="modal fade" id="designationEditFormModal{{$designation->id}}" tabindex="-1" role="dialog" aria-labelledby="designationEditFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="designationEditFormModalLabel">Designation Name</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="designation-edit modal-body">
                <form action="{{ route('designation.edit', $designation->id) }}" method="get" id="designationEditForm" >
                    @csrf
                    <div class="form-group">
                        <input value="{{ route('designation.edit', $designation->id) }}" type="hidden" class="hidden" aria-hidden="true" name="routePlaceHolder">
                        <label class="field-required" for="designationfield">name</label>
                        <input type="text" name="name" class="form-control" value="{{$designation->designation}}" required>
                    </div>
                    <div class='form-group'>
                        <label class="field-required" for="designationfield">domain</label>
                        @php
                        foreach($domains as $domain)
                            if($designation->domain_id!=NULL && $domain->id===($designation->domain_id)) $domainName = $domain->domain; 
                            if($designation->domain_id==NULL) $domainName = ' '; 
                        @endphp 
                        <select name="domain" class="form-control" >
                            <option value="{{$designation->domain_id}}">{{$domainName}}</option>
                            @foreach($domains as $domain)
                            <option value="{{$domain->id}}">{{$domain->domain}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>  
                </form>
            </div>
        </div>
    </div>
</div>
