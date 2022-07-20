<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;
use Modules\HR\Entities\Application;
use Modules\HR\Jobs\Recruitment\SendEmailToNonVerifiedApplicants;

class MailController extends Controller
{
   public function sendMail()
   {
       $applications = $applications = Application::where('is_verified', false)->where('created_at', '>=', '2022-07-06')->get();
       Mail::to('pankaj.kandpal@coloredcow.in')->send(new sendEmail($applications));
       SendEmailToNonVerifiedApplicants::dispatch($applications);
   }
}