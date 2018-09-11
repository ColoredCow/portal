<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\InvoiceRequest;
use App\Models\Client;
use App\Models\Finance\Invoice;
use App\Models\ProjectStageBilling;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Invoice::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('list', Invoice::class);

        $request = request();
        if ($request->get('start') && $request->get('end')) {
            $startDate = $request->get('start');
            $endDate = $request->get('end');
            $attr = [
                'invoices' => Invoice::filterBySentDate($startDate, $endDate, true)->appends(Input::except('page')),
                'startDate' => $startDate,
                'endDate' => $endDate,
            ];
        } else {
            $attr = [
                'invoices' => Invoice::getList(),
            ];
        }

        return view('finance.invoice.index')->with($attr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $clients = Client::getActiveClients();
        $clients->load('projects', 'projects.stages', 'projects.stages.billings');
        return view('finance.invoice.create')->with([
            'clients' => $clients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InvoiceRequest $request)
    {
        $validated = $request->validated();

        $path = self::upload($validated['invoice_file']);

        $invoice = Invoice::create([
            'project_invoice_id' => $validated['project_invoice_id'],
            'status' => $validated['status'],
            'currency' => $validated['invoice_currency'],
            'amount' => $validated['invoice_amount'],
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'due_on' => isset($validated['due_on']) ? DateHelper::formatDateToSave($validated['due_on']) : null,
            'gst' => isset($validated['gst']) ? $validated['gst'] : null,
            'comments' => $validated['comments'],
            'file_path' => $path,
        ]);

        foreach ($validated['billings'] as $billing) {
            ProjectStageBilling::where('id', $billing)->update(['invoice_id' => $invoice->id]);
        }

        if (isset($validated['request_from_billing']) && $validated['request_from_billing']) {
            $status = 'Billing invoice created successfully!';
            return redirect()->back()->with('status', $status);
        }
        return redirect()->route('invoices.edit', $invoice)->with('status', 'Invoice created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        $projectStageBillings = $invoice->projectStageBillings;

        $projectStageBilling = $projectStageBillings->first();
        $client = $projectStageBilling->projectStage->project->client;
        $client->load('projects', 'projects.stages', 'projects.stages.billings');

        $billings = [];
        foreach ($projectStageBillings as $key => $billing) {
            $billing->load('projectStage', 'projectStage.project');
            $billings[] = $billing;
        }

        $attr = [
            'invoice' => $invoice,
            'clients' => Client::select('id', 'name')->get(),
            'invoice_client' => $client,
            'invoice_billings' => $billings,
        ];

        $invoice->load('payments');
        if ($invoice->payments->count()) {
            $payment = $invoice->payments->first();
            $paymentModeModel = $payment->mode_type::find($payment->mode_id);

            $attr['payment'] = $payment;
            $attr['paymentModeModel'] = $paymentModeModel;
        }

        return view('finance.invoice.edit')->with($attr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $validated = $request->validated();

        $invoiceUpdated = $invoice->update([
            'project_invoice_id' => $validated['project_invoice_id'],
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'amount' => $validated['invoice_amount'],
            'currency' => $validated['invoice_currency'],
            'gst' => isset($validated['gst']) ? $validated['gst'] : null,
            'comments' => $validated['comments'],
            'due_on' => $validated['due_on'] ? DateHelper::formatDateToSave($validated['due_on']) : null,
        ]);

        $invoiceBillings = $invoice->projectStageBillings->keyBy('id');
        foreach ($invoiceBillings as $billingId => $invoiceBilling) {
            if (!array_key_exists($billingId, $validated['billings'])) {
                $invoiceBillings[$billingId]->finance_invoice_id = null;
                $invoiceBillings[$billingId]->update();
            }
        }
        foreach ($validated['billings'] as $billing) {
            if (!array_key_exists($billing, $invoiceBillings)) {
                ProjectStageBilling::where('id', $billing)->update(['invoice_id' => $invoice->id]);
            }
        }

        return redirect()->route('invoices.edit', $invoice)->with('status', 'Invoice updated successfully!');
    }

    /**
     * Upload invoice file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string    path of the uploaded file
     */
    protected static function upload(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();

        if ($fileName) {
            return $file->storeAs(FileHelper::getCurrentStorageDirectory(), $fileName);
        }

        return $file->store(FileHelper::getCurrentStorageDirectory());
    }

    /**
     * Download invoice file.
     *
     * @param  string $year  uploaded year of the invoice file
     * @param  string $month uploaded month of the invoice file
     * @param  string $file  invoice file name
     * @param  boolean $inline download/view invoice file
     * @return mixed
     */
    public function download($year, $month, $file, $inline = true)
    {
        $headers = [
            'content-type' => 'application/pdf',
        ];

        $file_path = FileHelper::getFilePath($year, $month, $file);

        if (!$file_path) {
            return false;
        }

        if ($inline) {
            return Response::make(Storage::get($file_path), 200, $headers);
        }

        return Storage::download($file_path);
    }
}
