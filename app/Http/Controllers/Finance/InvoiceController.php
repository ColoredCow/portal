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
use Illuminate\Support\Facades\Request;
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
                'invoices' => Invoice::filterBySentDate($startDate, $endDate, true)->appends(Request::except('page')),
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
        return view('finance.invoice.create')->with([
            'clients' => Client::getInvoicableClients(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InvoiceRequest $request)
    {
        $validated = $request->validated();
        $args = self::prepareAttributes($validated, true);
        $invoice = Invoice::create($args);
        self::handleBillings($validated['billings'], $invoice);

        if (isset($validated['request_from_billing']) && $validated['request_from_billing']) {
            return redirect()->back()->with('status', 'Billing invoice created successfully!');
        }

        return redirect()->route('invoices.edit', $invoice)->with('status', 'Invoice created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     *
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::getInvoicableClients(collect($invoice->projectStageBillings)->pluck('id')->toArray());
        $invoice->load('projectStageBillings', 'projectStageBillings.projectStage', 'projectStageBillings.projectStage.project');

        return view('finance.invoice.edit')->with([
            'invoice' => $invoice,
            'clients' => $clients,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     * @param  \App\Models\Finance\Invoice  $invoice
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $validated = $request->validated();
        $args = self::prepareAttributes($validated);
        $invoice->update($args);
        self::handleBillings($validated['billings'], $invoice);

        return redirect()->route('invoices.edit', $invoice)->with('status', 'Invoice updated successfully!');
    }

    /**
     * Download the invoice file.
     *
     * @param  string $year  uploaded year of the invoice file
     * @param  string $month uploaded month of the invoice file
     * @param  string $file  invoice file name
     * @param  bool|bool $inline download/view invoice file
     *
     * @return mixed
     */
    public function download(string $year, string $month, string $file, bool $inline = true)
    {
        $filePath = FileHelper::getFilePath($year, $month, $file);
        if (! $filePath) {
            return false;
        }
        if ($inline) {
            $headers = [
                'content-type' => 'application/pdf',
            ];

            return Response::make(Storage::get($filePath), 200, $headers);
        }

        return Storage::download($filePath);
    }

    /**
     * Upload the invoice file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     *
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
     * Prepare attributes to store or update the resource.
     *
     * @param  array        $validated
     * @param  bool|bool $uploadFile
     *
     * @return array
     */
    protected static function prepareAttributes(array $validated, bool $uploadFile = false)
    {
        $args = [
            'project_invoice_id' => $validated['project_invoice_id'],
            'currency' => $validated['currency'],
            'amount' => $validated['amount'],
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'comments' => $validated['comments'],
        ];
        if ($uploadFile) {
            $args['file_path'] = self::upload($validated['invoice_file']);
        }
        if (isset($validated['gst'])) {
            $args['gst'] = $validated['gst'];
        }
        if (isset($validated['due_on'])) {
            $args['due_on'] = DateHelper::formatDateToSave($validated['due_on']);
        }

        return $args;
    }

    /**
     * Handles billings for the resource.
     *
     * @param  array   $billings
     * @param  Invoice $invoice
     *
     * @return void
     */
    protected static function handleBillings(array $billings, Invoice $invoice)
    {
        // If this is a newly generated invoice, we just add the billings.
        if ($invoice->wasRecentlyCreated) {
            foreach ($billings as $billing) {
                ProjectStageBilling::where('id', $billing)->update(['invoice_id' => $invoice->id]);
            }

            return;
        }

        // If this is an existing invoice, some billings may have been removed from it by the user.
        // Before updating the new billings, we need to detach the billings that were removed.
        $invoiceBillings = $invoice->projectStageBillings->keyBy('id');
        foreach ($invoiceBillings as $id => $billing) {
            if (! array_key_exists($id, $billings)) {
                $billing->update(['invoice_id' => null]);
            }
        }

        foreach ($billings as $billing) {
            // There may be some billings which are not removed. Hence we can reduce database
            // calls by checking if they're already present in the existing billings.
            if (! array_key_exists($billing, $invoiceBillings)) {
                ProjectStageBilling::where('id', $billing)->update(['invoice_id' => $invoice->id]);
            }
        }
    }
}
