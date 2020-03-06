<div class="align-items-end d-flex mt-1 row">
    <div class="col-2">
        <span>Newslatter</span> <span class="text-muted c-pointer">Edit</span>
    </div>

    <div class="col-10">
        <div class="row align-items-end d-flex">
            <div class="col-3">
                <span>Setup Mailchimp</span>
            </div>

            <div class="col-2">
                <select>
                    <option value="">Pending</option>
                    <option value="">In Progress</option>
                    <option value="">Completed</option>
                </select>
            </div>
        
            <div class="col-1">
                <div class="h-100 w-100">
                    <input type="number" class="form-control h-100 w-100 px-1">
                </div>
            </div>
        
            <div class="col-5">
                <div class="d-flex" style=" overflow: scroll !important; width: 28em;">
                    @foreach($monthDates ?:[] as $monthDate) 
                        <div style="min-width: 55px;" class="mr-2 flex-grow-0 h-50">
                            <span>{{ $monthDate['label']  }}</span>
                            <input class="w-100 h-100 form-control" min="0" type="number">
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

<hr>