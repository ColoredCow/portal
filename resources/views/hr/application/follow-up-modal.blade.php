<div class="modal fade" id="followUpModal" tabindex="-1" role="dialog" aria-labelledby="followUpModal"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-block">
                    <h5 class="modal-title">Follow up with {{ $applicationRound->application->applicant->name }}</h5>
                    <p class="text-secondary fz-14 leading-none mb-0 d-flex align-items-center">
                        <i class="fa fa-envelope mr-0.5"></i>
                        <span>{{ $applicationRound->application->applicant->email }}</span>
                        <span class="mx-1">–</span>
                        <i class="fa fa-phone mr-0.5"></i>
                        <span>{{ $applicationRound->application->applicant->phone }}</span>
                    </p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li class="mb-2">Read the resume and the feedbacks from the previous round.</li>
                    <li class="mb-2">Call and introduce yourself. Check if it is a good time to talk.</li>
                    <li class="mb-2">
                        <div class="mb-1">Ask if he/she have received the email to schedule interview and can check now.</div>
                        <ul>
                            <li class="mb-1 fz-16">Search with keyword "ColoredCow"</li>
                            <li class="mb-1 fz-16">Check in spam folder if not able to find. If found in spam, ask to mark it as not spam.</li>
                        </ul>
                    </li>
                    <li class="mb-2">Check for the reason for the delay for the interview schedule.</li>
                    <li class="mb-2">Add feedback on the communication skills.</li>
                    <li class="mb-2">If you want to know more about ColoredCow, you can check out our website at coloredcow.com</li>
                </ul>
                <form action="{{ route('hr.application-round.follow-up.store', $applicationRound) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="followUpComments" class="font-weight-bold fz-14 leading-none">Comments</label>
                            <textarea name="comments" id="followUpComments" class="form-control" rows="5" placeholder="Enter commments..."></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
