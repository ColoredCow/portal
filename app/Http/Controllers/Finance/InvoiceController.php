<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
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
        $invoice = Invoice::create([
            'name' => $request->input('name'),
            'project_id' => $request->input('project_id'),
            'project_invoice_id' => $request->input('project_invoice_id'),
            'status' => $request->input('status'),
            'sent_on' => date("Y-m-d", strtotime($request->input('sent_on'))),
            'paid_on' => $request->input('paid_on') ? date("Y-m-d", strtotime($request->input('paid_on'))) : null,
        ]);

        return redirect('/finance/invoices/' . $invoice->id . '/edit');
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
        $updated = $invoice->update([
            'name' => $request->input('name'),
            'project_id' => $request->input('project_id'),
            'project_invoice_id' => $request->input('project_invoice_id'),
            'status' => $request->input('status'),
            'sent_on' => date("Y-m-d", strtotime($request->input('sent_on'))),
            'paid_on' => $request->input('paid_on') ? date("Y-m-d", strtotime($request->input('paid_on'))) : null,
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
}
