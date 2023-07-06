<?php

namespace Modules\ProjectContract\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ProjectContract\Entities\Contract;
use Modules\ProjectContract\Entities\ProjectContractMeta;
use Modules\ProjectContract\Http\Requests\ProjectContractRequest;
use Modules\ProjectContract\Entities\Reviewer;
use Modules\ProjectContract\Entities\ContractReview;
use Modules\ProjectContract\Entities\ContractInternalReview;
use Modules\ProjectContract\Entities\ContractMetaHistory;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Modules\ProjectContract\Emails\ClientReview;
use Modules\ProjectContract\Emails\ClientApproveReview;
use Modules\ProjectContract\Emails\ClientUpdateReview;
use Modules\ProjectContract\Emails\FinanceReview;

class ProjectContractMailService
{
    public function sendClientReview($mail, $link)
    {
        Mail::to($mail)->send(new ClientReview($link));
    }
    public function sendClientResponse($mail)
    {
        Mail::to($mail)->send(new ClientApproveReview());
    }
    public function sendClientUpdate($mail)
    {
        Mail::to($mail)->send(new ClientUpdateReview());
    }
    public function sendFinanceReview($mail)
    {
        Mail::to($mail)->send(new FinanceReview());
    }
}