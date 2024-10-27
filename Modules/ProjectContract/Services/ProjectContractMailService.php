<?php
namespace Modules\ProjectContract\Services;

use Illuminate\Support\Facades\Mail;
use Modules\ProjectContract\Emails\ClientApproveReview;
use Modules\ProjectContract\Emails\ClientReview;
use Modules\ProjectContract\Emails\ClientUpdateReview;
use Modules\ProjectContract\Emails\FinanceReview;

class ProjectContractMailService
{
    public function sendClientReview($mail, $link)
    {
        Mail::to($mail)->queue(new ClientReview($link));
    }
    public function sendClientResponse($mail)
    {
        Mail::to($mail)->queue(new ClientApproveReview());
    }
    public function sendClientUpdate($mail)
    {
        Mail::to($mail)->queue(new ClientUpdateReview());
    }
    public function sendFinanceReview($mail)
    {
        Mail::to($mail)->queue(new FinanceReview());
    }
}
