<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Invoice;
use App\Models\Project;
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
            'invoices' => Invoice::with('project')->orderBy('sent_on', 'desc')->get(),
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
            'projects' => Project::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Finance\Invoice
     */
    public function store(Request $request)
    {
        $path = self::upload($request->file('invoice_file'));
        $invoice = Invoice::create([
            'name' => $request->input('name'),
            'project_id' => $request->input('project_id'),
            'project_invoice_id' => $request->input('project_invoice_id'),
            'status' => $request->input('status'),
            'sent_on' => date("Y-m-d", strtotime($request->input('sent_on'))),
            'paid_on' => $request->input('paid_on') ? date("Y-m-d", strtotime($request->input('paid_on'))) : null,
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
     * @return \Illuminate\View\View
     */
    public function edit(Invoice $invoice)
    {
        return view('finance.invoice.edit')->with([
            'invoice' => $invoice,
            'projects' => Project::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Finance\Invoice  $invoice
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Invoice $invoice)
    {
        $path = self::upload($request->file('invoice_file'));
        $updated = $invoice->update([
            'name' => $request->input('name'),
            'project_id' => $request->input('project_id'),
            'project_invoice_id' => $request->input('project_invoice_id'),
            'status' => $request->input('status'),
            'sent_on' => date("Y-m-d", strtotime($request->input('sent_on'))),
            'paid_on' => $request->input('paid_on') ? date("Y-m-d", strtotime($request->input('paid_on'))) : null,
            'file_path' => $path,
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
     * @return string
     */
    public static function upload(UploadedFile $file)
    {
        $dir = date('Y') . '/' . date('m');
        return $file->store($dir);
    }

    /**
     * Download invoice file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($year, $month, $file)
    {
        $file_path = $year . '/' . $month . '/' . $file;
        if (Storage::exists($file_path)) {
            return Storage::download($file_path);
        }
    }
}
