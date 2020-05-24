<?php

namespace Modules\Invoice\Services;

use Modules\Invoice\Entities\Invoice;
use Illuminate\Support\Facades\Storage;
use Modules\Client\Contracts\ClientServiceContract;
use Modules\Invoice\Contracts\InvoiceServiceContract;

class InvoiceService implements InvoiceServiceContract
{
    public function index()
    {
        return [
            'invoices' => Invoice::with('project')->status(request()->input('status', 'sent'))->get(),
            'clients' => app(ClientServiceContract::class)->getAll()
        ];
    }

    public function create()
    {
        return ['clients' => $this->getClientsForInvoice()];
    }

    public function store($data)
    {
        $invoice = Invoice::create($data);
        $this->saveInvoiceFile($invoice, $data['invoice_file']);
        return $invoice;
    }

    public function update($data, $id)
    {
        $invoice = Invoice::find($id);
        $invoice->update($data);
        if (isset($data['invoice_file']) and $data['invoice_file']) {
            $this->saveInvoiceFile($invoice, $data['invoice_file']);
        }

        return $invoice;
    }

    public function edit($id)
    {
        return [
            'invoice' => Invoice::find($id),
            'clients' => $this->getClientsForInvoice()
        ];
    }

    public function saveInvoiceFile($invoice, $file)
    {
        $folder = '/invoice/' . date('Y') . '/' . date('m');
        $fileName = $file->getClientOriginalName();
        $file = Storage::putFileAs($folder, $file, $fileName, ['visibility' => 'public']);
        $invoice->update(['file_path' => $file]);
    }

    public function getInvoiceFile($invoiceID)
    {
        $invoice = Invoice::find($invoiceID);
        return Storage::download($invoice->file_path);
    }

    public function getClientsForInvoice()
    {
        return app(ClientServiceContract::class)->getAll();
    }

    public function dashboard()
    {
        return Invoice::status('sent')->get();
    }
}
