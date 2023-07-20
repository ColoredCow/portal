<div class="certificate-modal modal fade" id="candidateCertificate{{ $applicant->id }}" tabindex="-1" z-index="1"
    role="dialog" aria-labelledby="candidateCertificate{{ $applicant->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('codetrek.generate-pdf',$applicant) }}" method="POST" id='certificateForm'>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><strong>Codetrek Certificate</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center justify-content-around">
                        <div class="form-group col-md-6 text-break">
                            <h6 class="fw-bold" for="name">{{ __('Name') }}</h6>
                            <h5>{{ $applicant->first_name }} {{ $applicant->last_name }}</h5>
                        </div>
                        <div class="form-group col-md-6 text-break">
                            <h6 for="email">{{ __('Email') }}</h6>
                            <h5>{{ $applicant->email }}</h5>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center justify-content-between">
                        <div class="form-group col-md-6 text-break">
                            <h6 for="startDate">{{ __('Start Date') }}</h6>
                            <h5>{{ $applicant->start_date }}</h5>
                        </div>
                        <div class="form-group col-md-6 text-break">
                            <h6 for="endDate">{{ __('End Date') }}</h6>
                            <h5>{{ date('Y-m-d') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-primary">Download</button>
                </div>
            </div>
        </form>
    </div>
</div>