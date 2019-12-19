<div class="align-items-end d-flex mt-4 row">
    <div class="col-2">
        <span>Newslatter</span>
    </div>

    <div class="col-2">
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
        <div class="h-75">
            <input type="number" class="form-control h-100">
        </div>
    </div>

    <div class="col-5">
        <div class="d-flex" style=" overflow: scroll !important; width: 28em;">
            @foreach($monthDates ?:[] as $monthDate) 
                <div style="min-width: 55px;" class="mr-2 flex-grow-0">
                    <span>{{ $monthDate['label']  }}</span>
                    <input class="w-100" min="0" type="number">
                </div>
            @endforeach
        </div>
    </div>
</div>

<hr>