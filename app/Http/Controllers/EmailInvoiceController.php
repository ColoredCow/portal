<?php

namespace App\Http\Controllers;

use Modules\User\Entities\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller;
use Modules\Invoice\Entities\Invoice;

class EmailInvoiceController extends Controller
{
    protected $name = 'invoice:invoices-list';

    public function handle()
    {
        $invoices = Invoice::with(['client', 'project'])->get();
        $user = new User;
        $user->email = 'finance@coloredcow.com';
        Mail::send(
            'invoice::mail.invoices-list',
            ['user' => $user, 'invoices' =>$invoices],
            function ($m) use ($user) {
                $m->from('finance@coloredcow.com');

                $m->to($user->email)->subject('List Of Invoices Sent');
            }
        );

        return redirect()->back();
    }
}
