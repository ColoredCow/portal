<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\InvoiceRequest;
use App\Models\Finance\Invoice;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
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
            'projects' => Project::select('id', 'name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Finance\InvoiceRequest  $request
     * @return \App\Models\Finance\Invoice
     */
    public function store(InvoiceRequest $request)
    {
        $validated = $request->validated();
        $path = self::upload($validated['invoice_file']);
        $invoice = Invoice::create([
            'name' => $validated['name'],
            'project_id' => $validated['project_id'],
            'project_invoice_id' => $validated['project_invoice_id'],
            'status' => $validated['status'],
            'sent_on' => Carbon::parse($validated['sent_on'])->format(config('constants.date_format')),
            'paid_on' => $validated['paid_on'] ? Carbon::parse($validated['paid_on'])->format(config('constants.date_format')) : null,
            'file_path' => $path
        ]);

        return redirect('/finance/invoices');
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
     */
    public function edit(Invoice $invoice)
    {
        return view('finance.invoice.edit')->with([
            'invoice' => $invoice,
            'projects' => Project::select('id', 'name')->get(),
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
            'name' => $validated['name'],
            'project_id' => $validated['project_id'],
            'project_invoice_id' => $validated['project_invoice_id'],
            'status' => $validated['status'],
            'sent_on' => Carbon::parse($validated['sent_on'])->format(config('constants.date_format')),
            'paid_on' => $validated['paid_on'] ? Carbon::parse($validated['paid_on'])->format(config('constants.date_format')) : null,
        ]);
        return redirect('/finance/invoices/' . $invoice->id . '/edit');
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
     * @return string   path of the uploaded file
     */
    protected static function upload(UploadedFile $file)
    {
        return $file->store(self::getCurrentStorageDirectory());
    }

    /**
     * Download invoice file.
     *
     * @param  string $year  uploaded year of the invoice file
     * @param  string $month uploaded month of the invoice file
     * @param  string $file  invoice file name
     * @return Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($year, $month, $file)
    {
        $file_path = self::getFilePath($year, $month, $file);
        if (Storage::exists($file_path)) {
            return Storage::download($file_path);
        }
    }

    /**
     * Retrieve file path based upon passed year and month
     *
     * @param  string $year  year directory of the file
     * @param  string $month month directory of the file
     * @param  string $file  invoice file name
     * @return string
     */
    protected static function getFilePath($year, $month, $file)
    {
        return $year . '/' . $month . '/' . $file;
    }

    /**
     * Retrieve storage directory based upon current year and month
     *
     * @return string
     */
    protected static function getCurrentStorageDirectory()
    {
        $now = Carbon::now();
        return $now->format('Y') . '/' . $now->format('m');
    }
}
