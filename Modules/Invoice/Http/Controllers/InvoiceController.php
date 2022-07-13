<?php

namespace Modules\Invoice\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\Invoice\Contracts\InvoiceServiceContract;
use Modules\Client\Entities\Client;
use Modules\Invoice\Entities\Invoice;

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
        $invoiceStatus = $request->invoice_status ?? 'sent';
        $filters = $request->all();

        if ($invoiceStatus == 'sent') {
            unset($filters['invoice_status']);
            $filters = $filters ?: $this->service->defaultFilters();
        } else {
            $invoiceStatus = 'ready';
            $filters = $request->all();
        }

        return view('invoice::index', $this->service->index($filters, $invoiceStatus));
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
    public function invoiceDetails(Request $request)
    {
        $filters = $request->all();

        if (! $filters) {
            return redirect(route('invoice.details', $this->service->defaultGstReportFilters()));
        }

        return view('invoice::monthly-gst-report', $this->service->invoiceDetails($filters));
    }

    public function monthlyGSTTaxReportExport(Request $request)
    {
        $filters = $request->all();

        return $this->service->monthlyGSTTaxReportExport($filters, $request);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->service->store($request->all());

        return redirect(route('invoice.index'))->with('success', 'Invoice created successfully!');
    }

    public function generateInvoice(Request $request)
    {
        $request->term = Carbon::parse($request->term . '-01')->subMonth()->format('Y-m');
        $data = $this->service->getInvoiceData($request->all());
        $invoiceNumber = $data['invoiceNumber'];
        $pdf = $this->showInvoicePdf($data);

        return $pdf->inline(str_replace('-', '', $invoiceNumber) . '.pdf');
    }

    public function generateInvoiceForClient(Request $request)
    {
        $client = Client::find($request->client_id);
        $data = $this->service->getInvoiceData([
            'client_id' => $client->id,
            'term' => today(config('constants.timezone.indian'))->subMonth()->format('Y-m'),
            'billing_level' => 'client',
            'sent_on' => today(config('constants.timezone.indian')),
            'due_on' => today(config('constants.timezone.indian'))->addWeek()
        ]);
        $invoiceNumber = $data['invoiceNumber'];
        $pdf = $this->showInvoicePdf($data);

        return $pdf->inline(str_replace('-', '', $invoiceNumber) . '.pdf');
    }

    public function showInvoicePdf($data)
    {
        $data['invoiceNumber'] = substr($data['invoiceNumber'], 0, -5);
        $pdf = App::make('snappy.pdf.wrapper');
        $html = view('invoice::render.render', $data);
        $pdf->loadHTML($html);

        return $pdf;
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
     * @param Invoice $invoice
     */
    public function edit(Invoice $invoice)
    {
        return view('invoice::edit', $this->service->edit($invoice));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Invoice $invoice
     */
    public function update(Request $request, Invoice $invoice)
    {
        $this->service->update($request->all(), $invoice);

        return redirect(route('invoice.index'))->with('success', 'Invoice updated successfully!');
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

        return $this->service->taxReportExport($filters, $request);
    }

    public function sendReminderEmail(Request $request)
    {
        $invoice = Invoice::find($request->invoice_id);
        $this->service->sendInvoiceReminder($invoice, $request->all());

        return redirect()->back()->with('status', 'Invoice saved successfully.');
    }

    public function sendInvoice(Request $request)
    {
        $client = Client::find($request->client_id);
        $this->service->sendInvoice($client, $request->term, $request->all());

        return redirect()->back()->with('status', 'Invoice saved successfully.');
    }

    public function yearlyInvoiceReport(Request $request)
    {
        $filters = $request->all();

        return view('invoice::invoice-report', $this->service->yearlyInvoiceReport($filters, $request));
    }
}
