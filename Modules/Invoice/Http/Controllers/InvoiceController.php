<?php

namespace Modules\Invoice\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Modules\Invoice\Entities\Invoice;
use Modules\Invoice\Contracts\InvoiceServiceContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvoiceController extends Controller
{
    use AuthorizesRequests;

    protected $service;

    public function __construct(InvoiceServiceContract $service)
    {
        $this->authorizeResource(Invoice::class);
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
        $this->authorize('invoiceDetails', Invoice::class);
        $filters = $request->all();
        if (! $filters) {
            return redirect(route('invoice.details', $this->service->defaultGstReportFilters()));
        }

        return view('invoice::monthly-gst-report', $this->service->invoiceDetails($filters));
    }

    public function monthlyGstTaxReportExport(Request $request)
    {
        $this->authorize('monthlyGstTaxReportExport', Invoice::class);
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
        $data = $this->service->getInvoiceData([
            'client_id' => $request->client_id,
            'project_id' => $request->project_id,
            'term' => today(config('constants.timezone.indian'))->subMonth()->format('Y-m'),
            'sent_on' => today(config('constants.timezone.indian')),
            'due_on' => today(config('constants.timezone.indian'))->addDays(6),
            'period_start_date' => $request->period_start_date,
            'period_end_date' => $request->period_end_date
        ]);
        $invoiceNumber = $data['invoiceNumber'];
        $pdf = $this->showInvoicePdf($data);

        return $pdf->inline($invoiceNumber . '.pdf');
    }

    public function showInvoicePdf($data)
    {
        $data['invoiceNumber'] = $data['invoiceNumber'];
        $pdf = App::make('snappy.pdf.wrapper');

        $template = config('invoice.templates.invoice.clients.' . optional($data['client'])->name) ?: 'invoice-template';
        $html = view(('invoice::render.' . $template), $data);
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
     * @param Invoice $invoice
     */
    public function destroy(Invoice $invoice)
    {
        return $this->service->delete($invoice);
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
        $this->authorize('taxReport', Invoice::class);
        $filters = $request->all();
        if (! $filters) {
            return redirect(route('invoice.tax-report', $this->service->defaultTaxReportFilters()));
        }

        return view('invoice::tax-report', $this->service->taxReport($filters));
    }

    public function taxReportExport(Request $request)
    {
        $this->authorize('taxReportExport', Invoice::class);
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
        $this->service->sendInvoice($request->all());

        return redirect()->back()->with('status', 'Invoice saved successfully.');
    }

    public function yearlyInvoiceReport(Request $request)
    {
        $this->authorize('yearlyInvoiceReport', Invoice::class);
        $filters = $request->all();

        return view('invoice::invoice-report', $this->service->yearlyInvoiceReport($filters, $request));
    }

    public function yearlyInvoiceReportExport(Request $request)
    {
        $this->authorize('yearlyInvoiceReportExport', Invoice::class);
        $filters = $request->all();

        return $this->service->yearlyInvoiceReportExport($filters, $request);
    }

    public function ledgerAccountsIndex(Request $request)
    {
        $data = $this->service->getLedgerAccountData($request->all());

        return view('invoice::ledger-accounts.index')->with($data);
    }

    public function storeLedgerAccountData(Request $request)
    {
        $this->service->storeLedgerAccountData($request->all());

        return redirect()->back()->with('status', 'Data saved successfully.');
    }

    public function createCustomInvoice()
    {
        return view('invoice::create-custom-invoice', $this->service->create());
    }
}
