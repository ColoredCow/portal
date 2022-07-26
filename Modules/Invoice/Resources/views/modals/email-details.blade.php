<div class="modal fade" id="previewMails" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h4 class="modal-title">{{ __('Preview Mails') }}</h4>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($emails as $email)
                    <div class="card mt-4">
                        @csrf
                        <div class="card-header c-pointer" data-toggle="collapse" data-target="#type" aria-expanded="true" aria-controls="type">
                            <div class="container">
                                <div class="row">
                                <div class="col-md-auto">
                                    <span ><b>Type:</b></span>
                                    <span>{{ $email ['type']}} </span>
                                </div>
                                <div class="col">
                                    <span ><b>Sent on:</b></span>
                                    <span>{{ date('l h:s A jS F Y', strtotime($email['sent_on']))}} </span>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div id="type" class="collapse">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Subject</label>
                                            <input type="text" name="" class="form-control" value="{{ $email ['subject'] }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label >Mail body:</label>
                                            <textarea type="text" placeholder="{{ $email['body'] }}" rows="10" class=" form-control" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer justify-content-start">
                <div class="btn btn-primary close text-light" data-dismiss="modal" aria-label="Close">
                    {{ __('Close') }}
                </div>
            </div>
        </div>
    </div>
</div>