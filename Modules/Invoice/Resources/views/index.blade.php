@extends('invoice::layouts.master')
@section('content')

<div class="container" id="vueContainer">
    <br>
    <br>

    <div class="d-flex justify-content-between mb-2">
        <h4 class="mb-1 pb-1"> Invoices</h4>
        <span>
            <a href="{{ route('invoice.create') }}" class="btn btn-info text-white"> Add new invoice</a>
        </span>
    </div>
    <br>
    <br>

    <div>
        @include('invoice::index-filters')
    </div>

    <div class="font-muli-bold my-4">
        Current Exchange rates ($1) : &nbsp; ₹{{  $currencyService->getCurrentRatesInINR() }}
    </div>

    <div class="font-muli-bold my-4">
        Receivable amount (for current filters): &nbsp; ₹{{ $totalReceivableAmount }} 
    </div>

    <div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th></th>
                    <th>Project</th>
                    <th>Amount ( + taxes)</th>
                    <th>Sent on</th>
                    <th>Receivable date</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('invoice.edit', $invoice) }}">{{ $invoice->project->name }}</a>
                    </td>
                    <td>{{ $invoice->invoiceAmount() }}</td>
                    <td>{{ $invoice->sent_on->format(config('invoice.default-date-format')) }}</td>
                    <td class = '{{ $invoice->shouldHighlighted() ? 'font-weight-bold text-danger ' : ''}}'>
                        {{ $invoice->receivable_date->format(config('invoice.default-date-format'))  }}
                    </td>
                    <td class="{{ $invoice->status == 'paid' ? 'font-weight-bold text-success' : '' }}">{{ Str::studly($invoice->status) }}
                    @if($invoice->status == 'sent')    
                    <div class="mt-2">
                            <button type="button" style="text-decoration: underline;" data-toggle="modal" data-target="#pendinginvoiceModal" data-whatever="riyasuntwal91@gmail.com" class="btn btn-sm">Send Mail</button>
                    </div>
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    <div class="modal fade" id="pendinginvoiceModal" tabindex="-1" role="dialog" aria-labelledby="pendinginvoiceModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pendinginvoiceModalLabel">Sent by : finance@coloredcow.com</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('send.email') }}" method="post">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Recipient:</label>
                                <input type="text" class="form-control" id="name" name="name">
                                @error('name')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email-to" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="email">
                                @error('email')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="subject-text" class="col-form-label">Subject:</label>
                                <input type="text" class="form-control" id="subject" name="subject">
                                @error('subject')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Message:</label>
                                <textarea class="form-control" id="content" name="content"></textarea>
                                @error('content')
                                <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send message</button>
                        </div>
                        </div>
                    </div>
                    </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
<script>
  $('#pendinginvoiceModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var recipient = button.data('whatever');
  var modal = $(this);
  modal.find('.modal-title').text('New message to ' + recipient);
  modal.find('.modal-body input').val(recipient);
});
</script>
@endsection