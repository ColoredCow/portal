<tr>
    <td class="w-25p">
        <div class="d-flex align-items-center">
            <div class="d-flex align-items-center">
                <h2 class="fz-16 m-0 mr-1">#001</h2>
            </div>
        </div>
        <div class="mb-2 fz-xl-14 text-secondary d-flex flex-column">
            <div class="d-flex text-white my-2">
                     <button  class="btn-sm btn-primary mr-1 text-decoration-none" data-toggle="modal"
                     data-target="#modal-ticket-view">View </button>
            </div>
        </div>

        <div>
                <a href="" target="#" data-toggle="tooltip"
                    data-placement="top" title="GitHub" class="mr-1 text-decoration-none">
                    <span><i class="fa fa-github" aria-hidden="true"></i></span>
                </a>
        </div>
    </td>
    <td>
        <div class="d-flex flex-column">
            <span>Title of Issue</span>
            <span class="fz-xl-14 text-secondary">Raised on : </span>
            <span>{{ now()->format('d-m-Y') }}</span>
        </div>
    </td>
    <td class='text-danger'>High</td>
    <td class='text-danger'>Bug</td>
    <td>Closed</span>
    </td>
</tr>
@include('ticket::modals.ticket-view')
