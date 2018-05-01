<?php

namespace App\Http\Controllers\Finance;

use App\Helpers\DateHelper;
use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\InvoiceRequest;
use App\Models\Client;
use App\Models\Finance\Invoice;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('finance.invoice.index')->with([
            'invoices' => Invoice::getList(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('finance.invoice.create')->with([
            'clients' => Client::getActiveClients(),
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
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'sent_amount' => $validated['sent_amount'],
            'currency_sent_amount' => $validated['currency_sent_amount'],
            'gst' => $validated['gst'],
            'paid_on' => $validated['paid_on'] ? DateHelper::formatDateToSave($validated['paid_on']) : null,
            'paid_amount' => $validated['paid_amount'],
            'payment_type' => $validated['payment_type'],
            'cheque_status' => $validated['cheque_status'],
            'cheque_received_date' => isset($validated['cheque_received_date']) ? DateHelper::formatDateToSave($validated['cheque_received_date']) : null,
            'cheque_bounced_date' => isset($validated['cheque_bounced_date']) ? DateHelper::formatDateToSave($validated['cheque_bounced_date']) : null,
            'cheque_cleared_date' => isset($validated['cheque_cleared_date']) ? DateHelper::formatDateToSave($validated['cheque_cleared_date']) : null,
            'currency_paid_amount' => $validated['currency_paid_amount'],
            'comments' => $validated['comments'],
            'tds' => $validated['tds'],
            'currency_tds' => $validated['currency_tds'],
            'file_path' => $path
        ]);
        $invoice->projects()->sync($validated['project_ids']);

        return redirect("/finance/invoices/$invoice->id/edit")->with('status', 'Invoice created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return void
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        $project = $invoice->projects->first();
        $client = $project->client;
        $client_projects = $client->projects;

        return view('finance.invoice.edit')->with([
            'invoice' => $invoice,
            'clients' => Client::select('id', 'name')->get(),
            'invoice_client' => $client,
            'client_projects' => $client_projects,
        ]);
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
        $updated = $invoice->update([
            'project_invoice_id' => $validated['project_invoice_id'],
            'status' => $validated['status'],
            'sent_on' => DateHelper::formatDateToSave($validated['sent_on']),
            'sent_amount' => $validated['sent_amount'],
            'currency_sent_amount' => $validated['currency_sent_amount'],
            'gst' => $validated['gst'],
            'paid_on' => $validated['paid_on'] ? DateHelper::formatDateToSave($validated['paid_on']) : null,
            'paid_amount' => $validated['paid_amount'],
            'payment_type' => $validated['payment_type'],
            'cheque_status' => $validated['cheque_status'],
            'cheque_received_date' => isset($validated['cheque_received_date']) ? DateHelper::formatDateToSave($validated['cheque_received_date']) : null,
            'cheque_bounced_date' => isset($validated['cheque_bounced_date']) ? DateHelper::formatDateToSave($validated['cheque_bounced_date']) : null,
            'cheque_cleared_date' => isset($validated['cheque_cleared_date']) ? DateHelper::formatDateToSave($validated['cheque_cleared_date']) : null,
            'currency_paid_amount' => $validated['currency_paid_amount'],
            'comments' => $validated['comments'],
            'tds' => $validated['tds'],
            'currency_tds' => $validated['currency_tds'],
        ]);
        $invoice->projects()->sync($validated['project_ids']);

        return redirect("/finance/invoices/$invoice->id/edit")->with('status', 'Invoice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return void
     */
    public function destroy(Invoice $invoice)
    {
        //
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

        if($fileName) {
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
            'content-type'=>'application/pdf'
        ];

        $file_path = FileHelper::getFilePath($year, $month, $file);

        if(!$file_path) {
            return false;
        }

        if($inline) {
            return Response::make(Storage::get($file_path), 200, $headers);
        }

        return  Storage::download($file_path);
    }
}
