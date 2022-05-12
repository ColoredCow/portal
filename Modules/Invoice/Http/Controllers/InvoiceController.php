<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Invoice\Contracts\InvoiceServiceContract;
use Modules\Client\Entities\Client;
use Modules\Client\Entities\ClientAddress;
use Modules\Invoice\Entities\Invoice;
use Mail;
use Modules\Invoice\Emails\SendPendingInvoiceMail;
use Modules\Invoice\Rules\EmailValidation;

class InvoiceController extends Controller
{
    protected $service;

    public function __construct(InvoiceServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->all();

        if (! $filters) {
            return redirect(route('invoice.index', $this->service->defaultFilters()));
        }

        return view('invoice::index', $this->service->index($filters));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invoice::create', $this->service->create());
    }

    /**
     * Show the.
     */
    public function invoiceDetails()
    {
        $invoices = Invoice::all();
        foreach ($invoices as $invoice) :
            $clients[] = Client::select('*')->where('id', $invoice->client_id)->first();
        $clientAddress[] = ClientAddress::select('*')->where('id', $invoice->client_id)->first();
        endforeach;

        return view('invoice::invoice-details-listing', compact('invoices', 'clients', 'clientAddress'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $invoice = $this->service->store($request->all());

        return redirect(route('invoice.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     */
    public function edit($id)
    {
        return view('invoice::edit', $this->service->edit($id));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $this->service->update($request->all(), $id);

        return redirect(route('invoice.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    public function getInvoiceFile(Request $request, $invoiceID)
    {
        return $this->service->getInvoiceFile($invoiceID);
    }

    public function dashboard()
    {
        return $this->service->dashboard();
    }

    public function taxReport(Request $request)
    {
        $filters = $request->all();

        if (! $filters) {
            return redirect(route('invoice.tax-report', $this->service->defaultTaxReportFilters()));
        }

        return view('invoice::tax-report', $this->service->taxReport($filters));
    }

    public function taxReportExport(Request $request)
    {
        $filters = $request->all();

        return $this->service->taxReportExport($filters);
    }

    public function sendEmail(Request $request, Invoice $invoice, Client $client)
    {
        $senderEmail = $invoice->client->contactPersons()->get('email');
        $emails = $request->invoice_email;

        $validator = $request->validate([
        'invoice_email' => new EmailValidation(),
        ]);

        if ($emails != '') {
            $validate = preg_split('/[,]/', $emails);
            Mail::to($senderEmail)
            ->cc($validate)
            ->send(new SendPendingInvoiceMail($invoice));
        } else {
            Mail::to($senderEmail)
            ->send(new SendPendingInvoiceMail($invoice));
        }

        return redirect(route('invoice.index'));
    }
}
